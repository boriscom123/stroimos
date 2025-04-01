<?php
namespace ImportDocuments;

use AppBundle\Entity\DecisionDocument;
use AppBundle\Entity\DocumentHasMedia;
use AppBundle\Entity\DraftDocument;
use AppBundle\Entity\LawDocument;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Import\BaseImport;
use Import\ImportTagData;

class ImportDocumentData extends BaseImport implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportOutgoingAgencyData::class,
            ImportDocumentsRubricData::class
        ];
    }

    public function doLoad()
    {
        $mainTable = 'document';
        $tagTable = 'document_tag';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*, main.name as title, t.name as name_type, main.id as doc_id, main.created_at as created_at')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) . ') as tags')
            ->leftJoin('main', 'st_document_type', 't', 'main.document_type_id = t.id')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        $this->applyQuerySkips($mainTable, $query, 'document');

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);
        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 20;
        $this->getConsoleOutput()->writeln($mainTable);

        foreach ($query->execute() as $sourceRow) {
            $this->loadFromRow($sourceRow);

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');

        $this->manager->clear();
    }

    private function loadFromRow($sourceRow)
    {
        $sourceRow['name'] = $sourceRow['title'];
        $sourceRow['published_at'] = $sourceRow['created_at'];
        $sourceRow['is_published'] = true;

        $doc = null;
        if ($sourceRow['section'] == 'decree') {
            $doc = new LawDocument();
            $doc->setNumber($sourceRow['number']);
            $doc->setStatus($sourceRow['is_active']);
            if (isset(LawDocument::$types[((int) $sourceRow['document_type_id'] - 1)])) {
                $doc->setType(LawDocument::$types[((int) $sourceRow['document_type_id'] - 1)]);
            }
            $doc->setApproveDate(new \DateTime($sourceRow['approved_at']));
            if ($rubricId = (int)$sourceRow['document_category_id'] + ImportDocumentsRubricData::$startId) {
                $rubric = $this->manager->getRepository('AppBundle:DocumentRubric')->find($rubricId);
                if ($rubric) {
                    $doc->addRubric($rubric);
                }
            }

            if ($this->hasReference('outgoing-agency-'.$sourceRow['outgoing_authority_id'])) {
                $doc->setOutgoingAgency($this->getReference('outgoing-agency-'.$sourceRow['outgoing_authority_id']));
            }
        } elseif ($sourceRow['section'] == 'draft') {
            $doc = new DraftDocument();

            $doc->setArchive($sourceRow['is_active']);
            $doc->setDateOfAdding(new \DateTime($sourceRow['approved_at']));
            $doc->setDateOfReceipt(new \DateTime($sourceRow['created_at']));
            $doc->setExpirationDate(new \DateTime($sourceRow['expertise_finished_at']));
            $doc->setAddress($sourceRow['addresses_for_expertise_text_opinion_letter']);

            if ($sourceRow['druft_text_url'] && 0 === strpos($sourceRow['druft_text_url'], 'http')) {
                $doc->setExternalUrl($sourceRow['druft_text_url']);
            } elseif ($sourceRow['druft_text_url']) {
                if ($sourceRow['druft_text_url']) {
                    $this->loadMedia($sourceRow['druft_text_url'], function ($file) use ($doc, $sourceRow) {
                        $DocHasMedia = new DocumentHasMedia();
                        $DocHasMedia->setDocument($doc);
                        $DocHasMedia->setFile($file);
                        $DocHasMedia->setTitle($sourceRow['name']);
                        $doc->addFile($DocHasMedia);
                    }, 'file', 'sonata.media.provider.file');
                }
            }

        } else {
            $doc = new DecisionDocument();

            $doc->setApproveDate(new \DateTime($sourceRow['approved_at']));
            $doc->setNumber($sourceRow['number']);
            $doc->setStatus($sourceRow['is_active']);
        }

        if($doc) {
            if ($sourceRow['tags']) {
                $tagsTitles = explode('|', $sourceRow['tags']);
                $tags = $this->getTagsReferencesArray($tagsTitles);
                $doc->setTags($tags);
            }

            $this->getCommonFieldSetter()->importCommonFields($doc, $sourceRow);

            $doc->setTitle($sourceRow['name']);
            $doc->setPublishStartDate(new \DateTime($sourceRow['published_at']));
            $doc->setCreatedAt(new \DateTime($sourceRow['published_at']));
            $doc->setUpdatedAt(new \DateTime($sourceRow['published_at']));
            $doc->setSearchable(true);

            $this->disableAutoIncrement($doc);
            $doc->setId($sourceRow['doc_id']);
            $this->manager->persist($doc);
            $this->manager->flush();
        }
    }
}
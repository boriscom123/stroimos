<?php
namespace ImportDocuments;

use AppBundle\Entity\OutgoingAgency;
use Import\BaseImport;

class ImportOutgoingAgencyData extends BaseImport
{
    public function doLoad()
    {
        $mainTable = 'st_outgoing_authority';

        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from($mainTable)
        ;

        $totalCount  = $this->getSource()->getCountByQueryBuilder($query);
        $progressBar = $this->createProgressBar($totalCount);

        $this->getConsoleOutput()->writeln($mainTable);

        foreach ($query->execute() as $sourceRow) {
            $this->loadFromRow($sourceRow);

            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->clear();
    }

    private function loadFromRow($sourceRow)
    {
        $item = new OutgoingAgency();
        $item->setTitle($sourceRow['name']);

        $this->setReference('outgoing-agency-'. $sourceRow['id'], $item);

        $this->manager->persist($item);
        $this->manager->flush();
    }
}
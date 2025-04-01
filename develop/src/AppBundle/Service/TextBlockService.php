<?php

namespace AppBundle\Service;

use AppBundle\Entity\EmbeddedContent\TextBlock\TextBlock;
use AppBundle\Entity\EmbeddedContent\TextBlock\UsagePlace;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TextBlockService
{
    const PATTERN_TEMPLATE = '/{%s}(?!})/mi';

    /**
     * @var RegistryInterface
     */
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function replaceIn($content)
    {
        $textBlockRepository = $this->doctrine->getManager()->getRepository(TextBlock::class);
        $textBlocks = $textBlockRepository->findAll();

        if (empty($textBlocks)) {
            return $content;
        }

        $patterns = [];
        $replacement = [];
        foreach ($textBlocks as $textBlock) {
            $patterns[] = sprintf(self::PATTERN_TEMPLATE, $textBlock->getName());
            $replacement[] = $textBlock->getContent();
        }

        $newContent = preg_replace($patterns, $replacement, $content);
        $newContent = preg_replace(sprintf(self::PATTERN_TEMPLATE, '\w+'), '', $newContent);

        return $newContent;
    }

    public function updateTextBlockUsageInfo($object, $changeSet)
    {
        list($new, $deleted) = $this->findNewAndDeletedTextBlocks($changeSet);

        if (empty($new) && empty($deleted)) {
            return;
        }
        $usagePlace = $this->findOrCreateUsagePlaceBy($object);

        $textBlockRepository = $this->doctrine->getManager()->getRepository(TextBlock::class);
        $names = array_merge($new, $deleted);
        $textBlocks = $textBlockRepository->findBy(['name' => $names]);

        $new = array_combine($new, $new);
        /** @var TextBlock $textBlock */
        foreach ($textBlocks as $textBlock) {
            $name = $textBlock->getName();
            if (($new[$name])) {
                $textBlock->addUsagePlace($usagePlace);
            } else {
                $textBlock->removeUsagePlace($usagePlace);
            }
            $this->doctrine->getManager()->persist($textBlock);
        }
        $this->doctrine->getManager()->flush();
    }

    public function removeUsageInfo($object)
    {
        $usagePlaceRepository = $this->getUsagePlaceRepository();

        $usagePlace = $usagePlaceRepository->findOneBy(
            [
                'entityId' => $object->getId(),
                'class' => get_class($object),
            ]
        );

        if ($usagePlace === null) {
            return;
        }

        $this->doctrine->getManager()->remove($usagePlace);
        $classMetaData = $this->doctrine->getManager()->getClassMetadata(UsagePlace::class);
        $this->doctrine->getManager()->getUnitOfWork()->computeChangeSet($classMetaData, $usagePlace);
    }


    protected function findOrCreateUsagePlaceBy($object)
    {
        $usagePlaceRepository = $this->getUsagePlaceRepository();

        $usagePlace = $usagePlaceRepository->findOneBy(
            [
                'entityId' => $object->getId(),
                'class' => get_class($object),
            ]
        );

        if (null === $usagePlace) {
            $usagePlace = UsagePlace::createFromEntity($object);
            $this->doctrine->getManager()->persist($usagePlace);
            $classMetaData = $this->doctrine->getManager()->getClassMetadata(UsagePlace::class);
            $this->doctrine->getManager()->getUnitOfWork()->computeChangeSet($classMetaData, $usagePlace);
        }

        return $usagePlace;
    }

    protected function findNewAndDeletedTextBlocks($changeSet)
    {
        foreach ($changeSet as $property => list($oldValue, $newValue)) {
            if (($oldValue !== null && !is_string($oldValue)) || !is_string($newValue)) {
                continue;
            }
            list($new, $deleted) = $this->findNewAndDeletedTextBlocksInProperty($oldValue, $newValue);
        }

        return [
            isset($new) ? $new : [],
            isset($deleted) ? $deleted : [],
        ];
    }

    protected function findNewAndDeletedTextBlocksInProperty($oldValue, $newValue)
    {
        $new = [];
        $deleted = [];
        $matchesFromOrigin = [];
        $matchesFromCurrent = [];
        $pattern = sprintf(self::PATTERN_TEMPLATE, '(\w+)');
        preg_match_all($pattern, $oldValue, $matchesFromOrigin);
        preg_match_all($pattern, $newValue, $matchesFromCurrent);

        $tokensUsedInBothVersion = array_intersect($matchesFromOrigin[1], $matchesFromCurrent[1]);
        $newTokens = array_diff($matchesFromCurrent[1], $tokensUsedInBothVersion);
        $deletedTokens = array_diff($matchesFromOrigin[1], $tokensUsedInBothVersion);

        $new = array_unique(array_merge($new, $newTokens));
        $deleted = array_unique(array_merge($deleted, $deletedTokens));
        $deleted = array_diff($deleted, $new);

        return [$new, $deleted];
    }

    protected function getUsagePlaceRepository()
    {
        return $this->doctrine->getManager()->getRepository(UsagePlace::class);
    }
}

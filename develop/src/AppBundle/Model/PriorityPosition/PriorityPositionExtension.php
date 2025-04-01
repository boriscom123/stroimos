<?php
namespace AppBundle\Model\PriorityPosition;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class PriorityPositionExtension extends AdminExtension
{
    public function configureFormFields(FormMapper $form)
    {
        if ($form->has('priorityPosition')) {
            return;
        }

        if ('AppBundle\Entity\Post' === $form->getAdmin()->getClass()) {
            return;
        }

        $priorityPositionRepository = $form->getAdmin()
            ->getModelManager()
            ->getEntityManager($form->getAdmin()->getClass())
            ->getRepository($form->getAdmin()->getClass());

        if (!$priorityPositionRepository instanceof PriorityPositionRepositoryInterface) {
            throw new \RuntimeException("Repository for entity '" . $form->getAdmin()->getClass() . "' must implement PriorityPositionRepositoryInterface");
        }

        $positions = [];
        $displayPosition = 1;
        $currentIsLast = false;

        foreach ($priorityPositionRepository->getPriorityPositions($form->getAdmin()->getSubject()) as $existPosition) {
            if ($form->getAdmin()->getSubject()->getId() == $existPosition->getId()) {
                $displayTitle = ' (Текущая позиция)';
                $currentIsLast = true;
            } else {
                $displayTitle = ' (' . (string)$existPosition . ')';
                $currentIsLast = false;
            }

            $positions[$existPosition->getPriorityPosition()] = $displayPosition++ . $displayTitle;
        }

        if (empty($positions)) {
            $positions[1] = '1';
        } elseif(!$currentIsLast) {
            $newRealPosition = max(array_keys($positions)) + 1;
            $positions[$newRealPosition] = $displayPosition;
        }

        $positions[PriorityPositionInterface::DEFAULT_PRIORITY_POSITION] = 'Без приоритета';

        $form->add('priorityPosition', 'choice', array(
            'choices' => $positions
        ));
    }
}

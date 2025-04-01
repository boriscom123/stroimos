<?php
namespace Amg\Bundle\TagBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TagController extends CRUDController
{
    const NO_TARGET_MESSAGE = 'Требуется выбрать тег назначения';
    const ERROR_MESSAGE = 'Ошибка объеденения';
    const SUCCESS_MESSAGE = 'Теги успешно объеденены';

    public function batchActionMergeIsRelevant(array $selectedIds, $allEntitiesSelected)
    {
        $parameterBag = $this->get('request')->request;

        if (!$parameterBag->has('targetId')) {
            return self::NO_TARGET_MESSAGE;
        }

        $targetId = $parameterBag->get('targetId');

        if ($allEntitiesSelected) {
            return true;
        }

        $selectedIds = array_filter($selectedIds,
            function($selectedId) use($targetId){
                return $selectedId !== $targetId;
            }
        );

        return count($selectedIds) > 0;
    }

    public function batchActionMerge(ProxyQueryInterface $selectedModelQuery)
    {
        if (!$this->admin->isGranted('EDIT') || !$this->admin->isGranted('DELETE'))
        {
            throw new AccessDeniedException();
        }

        $request = $this->get('request');
        $modelManager = $this->admin->getModelManager();

        $target = $modelManager->find($this->admin->getClass(), $request->get('targetId'));

        if( $target === null){
            $this->addFlash('sonata_flash_info', self::NO_TARGET_MESSAGE);

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $selectedModelQuery
            ->andWhere($selectedModelQuery->getRootAlias() . " != :target")
            ->setParameter('target', $target);
        $selectedModels = $selectedModelQuery->execute();

        try {
            $this->container->get('amg_tag.manager')->merge($selectedModels, $target);
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', self::ERROR_MESSAGE);

            return new RedirectResponse(
                $this->admin->generateUrl('list',$this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', self::SUCCESS_MESSAGE);

        return new RedirectResponse(
            $this->admin->generateUrl('list',$this->admin->getFilterParameters())
        );
    }
}
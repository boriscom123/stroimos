<?php

namespace AppBundle\Block;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\SingleOwner;
use AppBundle\Service\AdminLocator;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MaterialOwnerLinkBlock extends AbstractBlockService
{
    /**
     * @var AdminLocator
     */
    protected $adminLocator;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function setAdminLocator(AdminLocator $adminLocator)
    {
        $this->adminLocator = $adminLocator;
    }

    /**
     * @param TokenStorage $tokenStorage
     */
    public function setTokenStorage(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => 'Block/material_owner_link.html.twig',
            'object' => null
        );
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        /** @var IdentifiableInterface $object */
        $object = $blockContext->getSetting('object');
        /** @var SingleOwner $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $actions = null;

        if ($user->getOwner() !== null && $object instanceof MultiOwner) {
            $actions = [
                'link' => ['url' => '', 'active' => false],
                'unlink' => ['url' => '', 'active' => false]
            ];
            $activeAction = $object->hasOwner($user->getOwner()) ? 'unlink' : 'link';
            $actions[$activeAction]['active'] = true;

            $admin = $this->adminLocator->getAdminForObject($object);
            foreach ($actions as $name => $action) {
                $action['url'] = $admin->generateUrl($name, ['id' => $object->getId()]);
                $actions[$name] = $action;
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'context' => $blockContext,
            'block' => $this,
            'actions' => $actions
        ), $response);
    }
}

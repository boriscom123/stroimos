<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Owner;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\SingleOwner;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

abstract class BaseAdmin extends Admin
{
    /**
     * @var mixed
     */
    private $user;

    /**
     * @var bool
     */
    protected $updateDefaultFilterParameters = true;

    /**
     * @inheritdoc
     */
    public function getFilterParameters()
    {
        if($this->updateDefaultFilterParameters) {
            $this->setDefaultFilterParameters();
        }

        return parent::getFilterParameters();
    }

    protected function setDefaultFilterParameters()
    {
        $owner = $this->getUserOwner();
        if($owner === null) {
            return;
        }

        $filter = $this->request->query->get('filter', []);

        $className = $this->getClass();
        $class = new $className();
        if($class instanceof MultiOwner) {
            if(!isset($filter['owners'])) {
                $filter['owners'] = [
                    'type' => '',
                    'value' => $owner->getId()
                ];
            }
        }

        $this->request->query->set('filter', $filter);
    }

    /**
     * @return Owner|null
     */
    public function getUserOwner()
    {
        if($this->user === null) {
            /** @var TokenInterface $token */
            $token = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken();
            $this->user = $token->getUser();
        }

        if($this->user instanceof SingleOwner) {
            return $this->user->getOwner();
        }

        return null;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function addOwnerDatagridFilter(DatagridMapper $datagridMapper)
    {
        $owner = $this->getUserOwner();
        if($owner === null) {
            return;
        }

        $className = $this->getClass();
        $class = new $className();
        if($class instanceof MultiOwner) {
            $datagridMapper->add('owners', 'doctrine_orm_model', ['mapping_type' => 8], 'entity', [
                'class' => 'AppBundle:Owner',
                'choice_translation_domain' => true
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();

        if($owner = $this->getUserOwner()) {
            if($instance instanceof SingleOwner) {
                $instance->setOwner($owner);
            } elseif ($instance instanceof MultiOwner) {
                $instance->setOwners(new ArrayCollection([$owner]));
            }
        }

        return $instance;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('link',  $this->getRouterIdParameter() . '/link');
        $collection->add('unlink', $this->getRouterIdParameter() . '/unlink');
    }
}

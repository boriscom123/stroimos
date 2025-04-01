<?php
namespace AppBundle\Admin;

use AppBundle\Entity\UserRole;
use AppBundle\Role\EditableRolesBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserRoleAdmin extends Admin
{
    protected $datagridValues = [
        '_sort_by' => 'code',
        '_sort_order'=> 'ASC',
    ];

    /** @var EditableRolesBuilder */
    private $rolesBuilder;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'edit']);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('code');
        $list->add('description', 'string', ['template' => ':UserRoleAdmin:CRUD/description.html.twig']);
        $list->add('teaser');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('code', null, ['help' => $this->rolesBuilder->getLabel($this->getSubject()->getId())]);
        $form->add('teaser');
    }

    public function setRolesBuilder(EditableRolesBuilder $rolesBuilder)
    {
        $this->rolesBuilder = $rolesBuilder;
    }

    /**
     * @return EditableRolesBuilder
     */
    public function getRolesBuilder()
    {
        return $this->rolesBuilder;
    }

    public function getObject($id)
    {
        $object = parent::getObject($id);

        if (!$object) {
            $object = new UserRole();
            $object->setCode($id);
        }

        return $object;
    }
}

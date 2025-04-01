<?php
namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class BaseGuardExtension extends AdminExtension
{
    /**
     * @param \Sonata\AdminBundle\Admin\AdminInterface $admin
     * @param $actionName
     * @param \Sonata\AdminBundle\Datagrid\ProxyQueryInterface $queryProxy
     * @param array $idx
     * @param $allElements
     */
    public function preBatchAction(AdminInterface $admin, $actionName, ProxyQueryInterface $queryProxy, array & $idx, $allElements)
    {
        if ('delete' === $actionName) {
            /** @var ProxyQuery $queryProxy */
            $qb = $queryProxy->getQueryBuilder();

            $objects = ('on' === $allElements)
                ? array_map(function ($v) { return $v[0]; }, iterator_to_array($queryProxy->getQuery()->iterate()))
                : array_map(function ($id) use ($admin) { return $admin->getObject($id); }, $idx);

            foreach ($objects as $object) {
                try {
                    $this->preRemove($admin, $object);
                } catch (ModelManagerException $e) {
                }
            }
        }
    }
}

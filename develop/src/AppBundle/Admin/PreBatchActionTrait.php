<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

trait PreBatchActionTrait
{
    public function preBatchAction($actionName, ProxyQueryInterface $query, array &$idx, $allElements)
    {
        foreach ($this->extensions as $extension) {
            if (method_exists($extension, __FUNCTION__)) {
                $extension->{__FUNCTION__}($this, $actionName, $query, $idx, $allElements);
            }
        }
    }
}

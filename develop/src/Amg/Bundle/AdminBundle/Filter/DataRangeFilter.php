<?php

namespace Amg\Bundle\AdminBundle\Filter;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Filter\Filter;

class DataRangeFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    public function filter(ProxyQueryInterface $queryBuilder, $alias, $field, $data)
    {
        if (!$data || !is_array($data) || !array_key_exists('value', $data)) {
            return;
        }

        /** @var \DateTime[] $dates */
        $dates = $data['value'];
        if (isset($dates['start']) && $dates['start'] instanceof \DateTime) {
            $queryBuilder->andWhere("$alias.$field >= :start");
            $queryBuilder->setParameter('start', $dates['start']->format('Y-m-d 00:00:00'));
        }
        if (isset($dates['end']) && $dates['end'] instanceof \DateTime) {
            $queryBuilder->andWhere("$alias.$field <= :end");
            $queryBuilder->setParameter('end', $dates['end']->format('Y-m-d 23:59:59'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getRenderSettings()
    {
        $t = $this->getFieldType();
        return array('amg_filter_date_range', array(
            'field_type'    => $this->getFieldType(),
            'field_options' => $this->getFieldOptions(),
            'label'         => $this->getLabel()
        ));
    }
}

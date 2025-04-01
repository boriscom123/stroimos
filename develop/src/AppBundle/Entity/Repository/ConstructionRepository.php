<?php

namespace AppBundle\Entity\Repository;

use CrEOF\Spatial\PHP\Types\Geometry\MultiPolygon;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;

class ConstructionRepository extends EntitySpecificationRepository
{
    public function getFinishYearsRange()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select($qb->expr()->min('c.endYear'))
            ->addSelect($qb->expr()->max('c.endYear'));

        return $qb->getQuery()->getSingleResult();
    }

    public function getConstruction($id)
    {
        return $this->createQueryBuilder('c')
            ->select('c, o')
            ->leftJoin('c.organization', 'o')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult();
    }

    public function findAllInSidePolygone(MultiPolygon $polygon)
    {
        $tableName = $this->getClassMetadata()->getTableName();
        $tableAlias = 'c';

        $sql = "select 
            {$tableAlias}.id,
            {$tableAlias}.administrative_unit_id,
            {$tableAlias}.object_id,
            {$tableAlias}.object_name,
            {$tableAlias}.data_object_id,
            {$tableAlias}.data_object_name,
            {$tableAlias}.data_object_area,
            {$tableAlias}.data_object_district,
            {$tableAlias}.data_object_address,
            {$tableAlias}.data_construction_work_type,
            {$tableAlias}.data_main_functional,
            {$tableAlias}.data_source_of_finance,
            {$tableAlias}.data_square,
            {$tableAlias}.data_floor,
            {$tableAlias}.data_object_status,
            {$tableAlias}.data_developer_org_form,
            {$tableAlias}.data_developer_org_name,
            {$tableAlias}.custom_data_main_functional,
            {$tableAlias}.custom_data_object_status,
            {$tableAlias}.custom_data_point_xy_geometry_coordinates,
            {$tableAlias}.data_point_xy_geometry_coordinates,
            {$tableAlias}.data_land_geometry_coordinates
            
            from {$tableName} {$tableAlias} 
            where 
              {$tableAlias}.publishable = 1 
              and  ST_Intersects({$tableAlias}.point, geomfromtext('MULTIPOLYGON({$polygon})')) = 1";

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata($this->getClassName(), $tableAlias);
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    public function findAvailableEndYearCollection()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('DISTINCT  s.endYear');
        $qb->orderBy('s.endYear', 'DESC');

        $result = $qb->getQuery()->getArrayResult();
        if (!empty($result)) {
            $result = array_column($result, 'endYear');
        }

        return $result;
    }

    public function findAvailableStartYearCollection()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('DISTINCT  s.startYear');
        $qb->orderBy('s.startYear', 'DESC');

        $result = $qb->getQuery()->getArrayResult();
        if (!empty($result)) {
            $result = array_column($result, 'startYear');
        }

        return $result;
    }
}

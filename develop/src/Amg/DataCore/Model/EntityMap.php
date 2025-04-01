<?php
namespace Amg\DataCore\Model;

use Symfony\Component\DependencyInjection\Container;

class EntityMap
{
    const ENTITY_NAMESPACE = 'AppBundle\\Entity\\';
    const ENTITY_NAMESPACE2 = 'ExtraBundle\\Entity\\';

    const PROXY_NAMESPACE_PREFIX = 'Proxies\__CG__\\';

    public static function getClassByAlias($alias)
    {
        $class = self::ENTITY_NAMESPACE . Container::camelize($alias);

        if (class_exists($class)) {
            return $class;
        }

        $class = self::ENTITY_NAMESPACE2 . Container::camelize($alias);

        if (class_exists($class)) {
            return $class;
        }

        throw new \RuntimeException("Class with alias '$alias' not found");
    }

    public static function getAlias($objectOrClass)
    {
        if (is_object($objectOrClass)) {
            $class = get_class($objectOrClass);
        } else {
            $class = $objectOrClass;

            if (strpos($objectOrClass, '\\') === false) {
                $class = self::ENTITY_NAMESPACE . '\\' . $class;
            }
        }

        if (strpos($class, self::PROXY_NAMESPACE_PREFIX) === 0) {
            $class = substr($class, strlen(self::PROXY_NAMESPACE_PREFIX));
        }

        if (
            strpos($class, self::ENTITY_NAMESPACE) !== 0 &&
            strpos($class, self::ENTITY_NAMESPACE2) !== 0
        ) {
            throw new \RuntimeException("Class '$class' not mapped");
        }

        if (!class_exists($class)) {
            throw new \RuntimeException("Class '$class' not found");
        }

        $alias = substr(strrchr($class, '\\'), 1);

        return Container::underscore($alias);
    }
}

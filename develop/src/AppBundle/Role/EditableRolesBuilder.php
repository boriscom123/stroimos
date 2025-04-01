<?php
namespace AppBundle\Role;

use AppBundle\Entity\UserRole;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Pool;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;

class EditableRolesBuilder
{
    private static $actionRoles = [
        'EDIT' => 'Редактирование',
        'LIST' => 'Просмотр списка',
        'CREATE' => 'Создание',
        'VIEW' => 'Просмотр',
        'DELETE' => 'Удаление',
        'EXPORT' => 'Экспорт',
        'OPERATOR' => 'Оператор',
        'MASTER' => 'Хозяин',
    ];

    private static $containerRoles = [
        'ROLE_USER' => 'Пользователь',
        'ROLE_SONATA_ADMIN' => 'Пользователь административного интерфейса',
        'ROLE_ADMIN' => 'Администратор',
        'ROLE_SUPER_ADMIN' => 'Суперадминистратор',
        'ROLE_ALLOWED_TO_SWITCH' => 'Перевоплощение',
        //todo: remove on extra remove
        'ROLE_VIP_JOURNALIST' => 'VIP журналист',
        'ROLE_EVENT_MODERATOR' => 'Модератор чата мероприятий',
        'ROLE_JOURNALIST' => 'Журналист',
        'ROLE_NOTIFICATION_SENDER' => 'Отправка уведомлений'
    ];

    protected $securityContext;

    protected $pool;

    protected $rolesHierarchy;

    /** @var array */
    private $adminAttributes;

    /** @var TranslatorInterface */
    private $translator;

    /** @var EntityManager */
    private $em;

    /**
     * @param SecurityContextInterface $securityContext
     * @param Pool $pool
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     * @param array $rolesHierarchy
     */
    public function __construct(SecurityContextInterface $securityContext, Pool $pool, EntityManager $em, TranslatorInterface $translator, $rolesHierarchy = array())
    {
        $this->securityContext = $securityContext;
        $this->pool = $pool;
        $this->rolesHierarchy = $rolesHierarchy;
        $this->translator = $translator;
        $this->em = $em;

        $this->userRoles = $this->em->createQuery('SELECT r FROM AppBundle\Entity\UserRole r INDEX BY r.code')->getResult();
    }

    public function setAdminAttributes($adminAttributes)
    {
        $this->adminAttributes = $adminAttributes;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = array();
        $rolesReadOnly = array();

        if (!$this->securityContext->getToken()) {
            return array($roles, $rolesReadOnly);
        }

        // get roles from the Admin classes
        foreach ($this->pool->getAdminServiceIds() as $id) {
            try {
                $admin = $this->pool->getInstance($id);
            } catch (\Exception $e) {
                continue;
            }

            $isMaster = $admin->isGranted('MASTER');
            $securityHandler = $admin->getSecurityHandler();
            // TODO get the base role from the admin or security handler
            $baseRole = $securityHandler->getBaseRole($admin);

            foreach ($admin->getSecurityInformation() as $actionRole => $permissions) {
                $role = sprintf($baseRole, $actionRole);

                $roleAttributesTranslated = $this->getRoleAttributesTranslated($role);
                $roleDescription = implode('. ', array_filter([$roleAttributesTranslated['action'], $this->getDescription($role)]));

                if ($isMaster) {
                    // if the user has the MASTER permission, allow to grant access the admin roles to other users
                    $roles[$roleAttributesTranslated['group']][$roleAttributesTranslated['label']][$role] = $roleDescription ?: $role;
                } elseif ($this->securityContext->isGranted($role)) {
                    // although the user has no MASTER permission, allow the currently logged in user to view the role
                    $rolesReadOnly[$roleAttributesTranslated['group']][$roleAttributesTranslated['label']][$role] = $roleDescription ?: $role;
                }
            }
        }

        $isMaster = $this->securityContext->isGranted('ROLE_SUPER_ADMIN');

        // get roles from the service container
        foreach ($this->rolesHierarchy as $name => $rolesHierarchy) {
            if ($this->securityContext->isGranted($name) || $isMaster) {
                $roles[$name] = implode(' — ', array_filter([
                    (isset(self::$containerRoles[$name]) ? self::$containerRoles[$name] : $name) . ': ' . implode(', ', array_map(function ($v) {
                        return isset(self::$containerRoles[$v]) ? self::$containerRoles[$v] : $v;
                    }, $rolesHierarchy)),
                    $this->getDescription($name),
                ]));

                foreach ($rolesHierarchy as $role) {
                    if (!isset($roles[$role])) {
                        $roles[$role] = implode(' — ', array_filter([
                            isset(self::$containerRoles[$role]) ? self::$containerRoles[$role] : $role,
                            $this->getDescription($role),
                        ]));
                    }
                }
            }
        }

        return array($roles, $rolesReadOnly);
    }

    public function getRoleAttributesTranslated($role)
    {
        $rolePattern = sprintf('/_(%s)$/', implode('|', array_keys(self::$actionRoles)));

        if (preg_match($rolePattern, $role, $matches)) {
            $baseRolePattern = preg_replace($rolePattern, '_%s', $role);
            if (isset($this->adminAttributes[$baseRolePattern])) {
                $attributes = $this->adminAttributes[$baseRolePattern];
                return [
                    'group' => $this->translator->trans($attributes['group'], [], $attributes['label_catalogue']),
                    'label' => $this->translator->trans($attributes['label'], [], $attributes['label_catalogue']),
                    'action' => self::$actionRoles[$matches[1]],
                ];
            }
        } elseif (isset(self::$containerRoles[$role])) {
            return [
                'group' => '',
                'label' => self::$containerRoles[$role],
                'action' => '',
            ];
        }

        throw new \RuntimeException(sprintf('Unexpected role «%s»', $role));
    }

    public function getLabel($role)
    {
        $roleAttributesTranslated = $this->getRoleAttributesTranslated($role);

        return implode('. ', array_filter([$roleAttributesTranslated['group'], implode('/', array_filter([$roleAttributesTranslated['label'], $roleAttributesTranslated['action']]))]));
    }

    private function getDescription($role)
    {
        $result = '';

        if (array_key_exists($role, $this->userRoles)) {
            /** @var UserRole $userRole */
            $userRole = $this->userRoles[$role];

            $result = $userRole->getTeaser();
        }

        return $result;
    }
}

<?php
namespace AppBundle\ActionLogger;

use AppBundle\Admin\Audit\AuditReader;
use AppBundle\Entity\ActionLog;
use SimpleThings\EntityAudit\AuditException;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;

class ActionLoggerExtension extends AdminExtension
{
    /**
     * @var ActionLogger
     */
    private $logger;
    /**
     * @var AuditReader
     */
    private $auditReader;

    public function __construct($logger, AuditReader $auditReader)
    {
        $this->logger = $logger;
        $this->auditReader = $auditReader;
    }

    public function postPersist(AdminInterface $admin, $object)
    {
        $this->saveLog($admin, $object, ActionLog::ACTION_CREATE);
    }

    public function postUpdate(AdminInterface $admin, $object)
    {
        $this->saveLog($admin, $object, ActionLog::ACTION_UPDATE);
    }

    public function postRemove(AdminInterface $admin, $object)
    {
        $this->saveLog($admin, $object, ActionLog::ACTION_DELETE);
    }

    protected function saveLog(AdminInterface $admin, $object, $action)
    {
        $url = null;
        if ($action !== ActionLog::ACTION_DELETE) {
            $url = $admin->generateObjectUrl('edit', $object);
            try {
                $revisions = $this->auditReader->findRevisions(get_class($object), $object->getId());
                if (count($revisions) > 1) {
                    $url = $admin->generateObjectUrl(
                        'history_compare_revisions',
                        $object,
                        ['base_revision' => $revisions[0]->getRev(), 'compare_revision' => $revisions[1]->getRev()]
                    );
                }
            } catch (AuditException $exception) {
                // $object is not audited
            }
        }

        $this->logger->save(
            str_replace('._', '', $admin->getTranslationLabel($admin->getLabel())),
            $action,
            (string) $object,
            $url
        );
    }
}

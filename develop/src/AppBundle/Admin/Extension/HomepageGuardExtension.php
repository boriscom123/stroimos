<?php
namespace AppBundle\Admin\Extension;

use AppBundle\Entity\SpotlightItem;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryPicks;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostPicksHistory;
use AppBundle\Entity\Video;
use AppBundle\Entity\VideoPicks;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class HomepageGuardExtension extends BaseGuardExtension
{
    private static $supportMap = [
        Video::class => [VideoPicks::class, 'video'],
        Gallery::class => [GalleryPicks::class, 'gallery'],
        Post::class => [SpotlightItem::class, 'post'],
    ];

    public function preRemove(AdminInterface $admin, $object)
    {
        /** @var Admin $admin */
        /** @var ModelManager $modelManager */
        $modelManager = $admin->getModelManager();

        /** @var FlashBagInterface $flashBag */
        $flashBag = $admin->getRequest()->getSession()->getBag('flashes');

        $messages = [];

        if (!array_key_exists(get_class($object), self::$supportMap)) {
            throw new \InvalidArgumentException();
        }

        list($class, $assoc) = self::$supportMap[get_class($object)];

        $usagesCount = $modelManager->getEntityManager($class)
            ->createQuery(sprintf('SELECT COUNT(p) FROM %s p WHERE p.%s = :entity', $class, $assoc))
            ->setParameter('entity', $object)
            ->getSingleScalarResult();

        if ($usagesCount > 0) {
            $messages[] = sprintf('Элемент «%s» размещён на Главной странице%s',
                (string)$object,
                $object instanceof Post
                    ? ' в блоке <a href="' . $admin->getConfigurationPool()->getAdminByAdminCode('admin.spotlight_item')->generateUrl('list') . '">«В центре внимания»</a>'
                    : ''
            );
        }

        if ($object instanceof Post) {
            $entityManager = $modelManager->getEntityManager(PostPicksHistory::class);
            $dql = sprintf('SELECT pph FROM %s pph JOIN pph.posts p WITH p = :post', PostPicksHistory::class);
            $referencingPostPicksHistoryEntries = $entityManager
                ->createQuery($dql)
                ->setParameter('post', $object)
                ->getResult();
            if (count($referencingPostPicksHistoryEntries) > 0) {
                $links = [];
                foreach ($referencingPostPicksHistoryEntries as $entry) {
                    /** @var PostPicksHistory $entry */
                    $links[] = sprintf('<a href="%s">%s</a>',
                        $admin->getConfigurationPool()->getAdminByAdminCode('admin.post_picks_history')->generateObjectUrl('edit', $entry),
                        $entry->getDate()->format('d.m.Y')
                    );
                }

                $messages[] = sprintf('Элемент «%s» размещён на Главной странице в блоке «Топ-новости» (%s)',
                    (string)$object,
                    implode(', ', $links)
                );
            }
        }

        if (count($messages) > 0) {
            $flashBag->add('sonata_flash_error', implode('<br>', $messages));

            throw new ModelManagerException();
        }
    }
}

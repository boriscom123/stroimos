<?php
namespace AppBundle\Renderer;

use Application\FOS\CommentBundle\Entity\Comment;
use FOS\CommentBundle\Model\CommentInterface;
use Sonata\CoreBundle\Component\Status\StatusClassRendererInterface;

/**
 * Class CommentStatusRenderer
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class CommentStatusRenderer implements StatusClassRendererInterface
{
    /**
     * {@inheritdoc}
     */
    public function handlesObject($object, $statusName = null)
    {
        return $object instanceof Comment
            && in_array($statusName, array('info', 'success', 'warning', 'danger', null));
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusClass($object, $statusName = null, $default = '')
    {
        switch ($object->getState()) {
            case CommentInterface::STATE_PENDING:
                return 'info';
            case CommentInterface::STATE_VISIBLE:
                return 'success';
            case CommentInterface::STATE_DELETED:
                return 'warning';
            case CommentInterface::STATE_SPAM:
                return 'danger';
            default:
                return $default;
        }
    }
}

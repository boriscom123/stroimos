<?php
namespace AppBundle\Form\Type;

use FOS\CommentBundle\Form\CommentType as BaseCommentType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends BaseCommentType
{
    /**
     * Configures a Comment form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('subject', 'text');
        $builder->add('body', 'textarea');
        $builder->add('binaryContent', 'file', [
            'required' => false,
        ]);
    }

    public function getName()
    {
        return 'app_comment';
    }
}

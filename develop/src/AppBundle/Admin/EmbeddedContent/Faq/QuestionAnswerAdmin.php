<?php
namespace AppBundle\Admin\EmbeddedContent\Faq;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

class QuestionAnswerAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('question', null, [
            'required' => true
        ]);
        $form->add('answer', 'ckeditor', ['required' => true]);
        $form->add('weight', null, ['required' => true]);
    }
}

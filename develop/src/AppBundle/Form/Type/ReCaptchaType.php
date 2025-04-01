<?php
namespace AppBundle\Form\Type;

use AppBundle\EventListener\ReCaptchaValidationListener;
use AppBundle\Form\Extension\YandexCaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReCaptchaType extends AbstractType
{
    /**
     * @var ReCaptcha
     **/
    private $yandexCaptcha;

    /**
     * ReCaptchaType constructor.
     *
     * @param ReCaptcha $reCaptcha
     */
    public function __construct(YandexCaptcha $yandexCaptcha)
    {
        $this->yandexCaptcha = $yandexCaptcha;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new ReCaptchaValidationListener($this->yandexCaptcha));
    }
    /**
     * @inheritDoc
     */
    public function buildView(FormView $view, FormInterface $form,   array $options)
    {
        $view->vars['type'] = $options['type'];
    }
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('type', 'invisible')
            ->setAllowedValues('type', ['checkbox', 'invisible']);
    }

    public function getName()
    {
        return 're_captcha';
    }
}

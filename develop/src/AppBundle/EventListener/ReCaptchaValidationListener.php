<?php
namespace AppBundle\EventListener;

use AppBundle\Form\Extension\YandexCaptcha;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class ReCaptchaValidationListener implements EventSubscriberInterface
{
    private $yandexCaptcha;

    public function __construct(YandexCaptcha $yandexCaptcha)
    {
        $this->yandexCaptcha = $yandexCaptcha;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }

    public function onPostSubmit(FormEvent $event)
    {
        $request = Request::createFromGlobals();

        $result = $this->yandexCaptcha->verify($request->request->get('smart-token'), $request->getClientIp());

        if (!$result) {
            $event->getForm()->addError(new FormError('Капча не отмечена. Пожалуйста, попробуйте еще раз.'));
        }
    }
}

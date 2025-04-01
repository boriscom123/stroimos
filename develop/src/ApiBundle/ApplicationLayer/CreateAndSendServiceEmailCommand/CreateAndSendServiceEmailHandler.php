<?php

namespace ApiBundle\ApplicationLayer\CreateAndSendServiceEmailCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\CommandHandlerAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\ApplicationLayer\AbstractCommand\SymfonyCommandValidator;
use Application\Sonata\MediaBundle\Entity\Media;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bridge\Twig\TwigEngine;

class CreateAndSendServiceEmailHandler extends CommandHandlerAbstract
{

    const SERVICE_EMAIL = 'boriscom@mail.ru';
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var TwigEngine
     */
    private $twig;

    private $senderAddress;
    private $senderName;

    public function __construct(
        $commandClassName,
        SymfonyCommandValidator $validator = null,
        TwigEngine $twig,
        Swift_Mailer $mailer,
        $senderAddress,
        $senderName
    ) {
        parent::__construct($validator, $commandClassName);

        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->senderAddress = $senderAddress;
        $this->senderName = $senderName;
    }

    /**
     * @param CreatedAndSendServiceEmailCommandDto $command
     *
     * @return Media
     *
     * @throws CommandExecutionException
     */
    protected function execute($command)
    {
        $body = $this->twig->render(':Emails:service_email.html.twig', [
            'command' => $command,
        ]);

        $message = $this->createMessage();
        $message->setSubject($command->getTitle());
        $message->setTo(self::SERVICE_EMAIL);
        $message->setBody($body, 'text/html', 'UTF-8');

        $this->mailer->send($message);
    }

    /**
     * @return Swift_Message
     */
    protected function createMessage()
    {
        return \Swift_Message::newInstance()
            ->setFrom($this->senderAddress, $this->senderName);
    }
}

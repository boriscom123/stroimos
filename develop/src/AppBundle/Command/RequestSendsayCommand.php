<?php
namespace AppBundle\Command;

use AppBundle\Rest\SendSayClient;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestSendsayCommand extends ContainerAwareCommand
{
    const OPTION_METHOD = 'method';

    protected function configure()
    {
        $this->setName('app:sendsay:request')
            ->setDescription('Запрос к sendsay')
            ->addOption(
                self::OPTION_METHOD,
                null,
                 InputOption::VALUE_REQUIRED,
                'Метод'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $client = new SendSayClient(
            $container->getParameter('sendsay_account'),
            $container->getParameter('sendsay_key'),
            $container->getParameter('sendsay_group')
        );

        $method = $input->getOption(self::OPTION_METHOD);

        $data = [
            'subject' => 'Градостроительный комплекс Москвы',
            'message' => 'Test message',
            'url' => 'https://stroi.mos.ru',
        ];

        $res = $client->{$method}($data);
        $output->writeln([
            'SendSay result',
            '============',
            print_r($res, true),
        ]);
        return true;
    }
}

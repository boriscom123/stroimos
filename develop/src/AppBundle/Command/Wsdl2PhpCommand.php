<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wsdl2PhpGenerator\Config;
use Wsdl2PhpGenerator\Generator;

class Wsdl2PhpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:wsdl2php')
            ->setDescription('Generate php classes out of wsdl schema')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = new Generator();

        $generator->generate(
            new Config([
                'inputFile' => __DIR__ . '/test.wsdl',
                'outputDir' => $this->getContainer()->getParameter('kernel.root_dir'). '/../src/AppBundle/Soap/EMoscow/Type',
                'namespaceName' => 'AppBundle\\Soap\\EMoscow\\Type',
            ])
        );
    }
}

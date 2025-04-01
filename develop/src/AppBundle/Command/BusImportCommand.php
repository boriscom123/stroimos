<?php
namespace AppBundle\Command;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Organization;
use AppBundle\Soap\BusUgdMosRu\DumpStrategy;
use AppBundle\Soap\BusUgdMosRu\SoapClient;
use AppBundle\Soap\BusUgdMosRu\SoapResponse;
use AppBundle\Soap\BusUgdMosRu\WebServiceStrategy;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BusImportCommand extends ContainerAwareCommand
{
    const OPTION__DRY_RUN__LONG = 'dry-run';
    const OPTION__DUMP__LONG = 'dump';
    const OPTION__MAX__LONG = 'max';

    protected function configure()
    {
        $this
            ->setName('app:bus:import')
            ->setDescription('Импорт объектов капитального строительства из сервиса bus.ugd.mos.ru')
            ->addOption(
                self::OPTION__DUMP__LONG,
                null,
                InputOption::VALUE_NONE,
                'Делать дампы ответов сервиса'
            )
            ->addOption(
                self::OPTION__DRY_RUN__LONG,
                null,
                 InputOption::VALUE_NONE,
                'Не обращаться к сервису, брать данные из дампа'
            )
            ->addOption(
                self::OPTION__MAX__LONG,
                null,
                 InputOption::VALUE_REQUIRED,
                'Максимальное количество объектов для обработки',
                100
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var Logger $logger */
        $logger = $this->getContainer()->get('logger');

        $dryRun = $input->getOption(self::OPTION__DRY_RUN__LONG);
        if (!$dryRun) {
            $soapClient = new SoapClient(
                SoapClient::WSDL,
                [
                    'location' => $this->getContainer()->getParameter('bus_ugd_mos_ru.location'),
                ],
                $this->getContainer()->getParameter('bus_ugd_mos_ru.username'),
                $this->getContainer()->getParameter('bus_ugd_mos_ru.password')
            );
            $dataSourceStrategy = new WebServiceStrategy($soapClient);
        } else {
            $dataSourceStrategy = new DumpStrategy(__DIR__ . '/../DataFixtures/data/soap/prd');
        }

        $count = 0;
        $maxCount = (int) $input->getOption(self::OPTION__MAX__LONG);
        while ($maxCount -- > 0) {
            $soapResponse = $dataSourceStrategy->getNext();

            if (!$soapResponse->isObject()) {
                if ($soapResponse->isError()) {
                    $logger->addCritical(sprintf('SOAP-service returned an error: %s', $soapResponse->getError()));
                }

                break; // no more data or error
            }

            if ($input->getOption(self::OPTION__DUMP__LONG)) {
                $this->dumpResponse($soapResponse);
            }

            $em->getConnection()->beginTransaction();

            try {
                $constructionData = Construction::extractDataFromSoapResponse($soapResponse);
                /** @var Construction $construction */
                $construction = $em->getRepository('AppBundle:Construction')->findOneBy(['objectId' => $soapResponse->ObjectID]);
                if (!$construction) {
                    $construction = new Construction();
                    $construction->setPublishable(false);
                    $construction->setData($constructionData);
                } elseif ($constructionData->getUpdateDateTime() > $construction->getObjectUpdateDateTime()) {
                    $construction->setPendingData($constructionData);
                }

                //Устанавливаем объекту строительства организацию
                if(!$construction->getOrganization()) {
                    $organization = $this->getContainer()
                        ->get('app.construction.find_organization')
                        ->getOrganization($construction);
                    if($organization instanceof Organization) {
                        $construction->setOrganization($organization);
                    }
                }
                $construction->setEndYearFromSoapResponse($soapResponse);

                $em->persist($construction);
                $em->flush($construction);

                $soapResponse = $dataSourceStrategy->confirm();
                if ($soapResponse->isError()) {
                    throw new \RuntimeException(sprintf(
                        'Could not confirm receiving data. The error was: %s',
                        $soapResponse->getError()
                    ));
                }

                $em->getConnection()->commit();
                $count += 1;
            } catch (\Exception $e) {
                $em->getConnection()->rollBack();

                $logger->addCritical(sprintf(
                    'Unexpected error on attempt to import data from bus.ugd.mos.ru. Error message was: %s. Stack trace: %s',
                    $e->getMessage(),
                    $e->getTraceAsString()
                ));

                break;
            }
        }

        $output->writeln(sprintf('Objects imported: %u', $count));
    }

    //region fixme: Debugging code, remove
    public function dumpResponse(SoapResponse $soapResponse)
    {
        $dataFixturesDir = realpath($this->getContainer()->getParameter('kernel.root_dir') . '/../src/AppBundle/DataFixtures');
        $server = explode('/', trim(parse_url($this->getContainer()->getParameter('bus_ugd_mos_ru.location'), PHP_URL_PATH), '/'))[0];
        $dir = sprintf('%s/data/soap/%s', $dataFixturesDir, $server);

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        if (is_dir($dir)) {
            $updateDateTime = new \DateTime($soapResponse->UpdateDateTime);
            $filename = sprintf(
                '%s/%s__%s.xml',
                $dir,
                $updateDateTime->format('Y-m-d_H-i-s'),
                $soapResponse->ObjectID
            );
            if (!file_exists($filename)) {
                file_put_contents($filename, $soapResponse->getResponse());
            }
        }
    }
    //endregion
}

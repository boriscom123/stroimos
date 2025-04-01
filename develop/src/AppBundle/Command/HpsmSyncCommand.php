<?php
namespace AppBundle\Command;

use AppBundle\Entity\ErrorReport;
use AppBundle\Soap\EMoscow\SoapClient;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HpsmSyncCommand extends ContainerAwareCommand
{
    const PORTAL = 'Portal_017';
    const CATEGORY_PREFIX = 'Строительный мир_';

    protected function configure()
    {
        $this
            ->setName('app:hpsm:sync')
            ->setDescription('Sync ErrorReports with HPSM service');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $errorReportRepo = $em->getRepository('AppBundle:ErrorReport');

        $qb = $errorReportRepo->createQueryBuilder('er')
            ->where('er.hpsmId IS NULL')
            ->setMaxResults(1);

        $em->getConnection()->beginTransaction();
        try {
            /** @var ErrorReport $errorReport */
            $errorReport = $qb->getQuery()
                ->setLockMode(LockMode::PESSIMISTIC_WRITE)
                ->getSingleResult();

            $this->createErrorReportTicket($errorReport);

            $em->flush($errorReport);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            if (!$e instanceof NoResultException) {
                throw $e;
            }
        }
    }

    protected function createErrorReportTicket(ErrorReport $errorReport)
    {
        $soapClient = $this->getSoapClient();

        if ($errorReport->getUser()) {
            $email = $errorReport->getUser()->getEmail();
        } else {
            $email = $errorReport->getEmail() ?: 'info@stroi.mos.ru';
        }

        $response = $soapClient->callCreatePortalInteraction(
            self::CATEGORY_PREFIX . $errorReport->getCategoryName(),
            $errorReport->getMessage(),
            self::PORTAL,
            $email,
            $errorReport->getCategoryName()
        );

        $errorReport->setHpsmId(
            $response->getModel()->getKeys()->getID()->get_()
        );
    }

    protected function getSoapClient()
    {
        $soapClient = new SoapClient(
//            'http://212.45.30.5:8090/SM/7/HPSMInteractionsFromMosRu.wsdl',
            __DIR__ . '/HPSMInteractionsFromMosRu.wsdl',
            [],
            $this->getContainer()->getParameter('e_moscow_hpsm.username'),
            $this->getContainer()->getParameter('e_moscow_hpsm.password')
        );

        return $soapClient;
    }
}

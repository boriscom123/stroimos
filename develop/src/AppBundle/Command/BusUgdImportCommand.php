<?php

namespace AppBundle\Command;

use AppBundle\BusImport\BusUgd;
use AppBundle\Entity\Construction;
use AppBundle\Entity\ConstructionType;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Entity\ImportFilter;
use AppBundle\Entity\Organization;
use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BusUgdImportCommand extends ContainerAwareCommand
{
    const OPTION__DAILY = 'daily';
    const OPTION__TYPE_INDEX = 'index';
    const OPTION__PAGE = 'page';
    const OPTION__LIMIT = 'limit';

    private $daily = true;
    private $count = 0;
    private $page = 0;
    private $filter = 0;
    /**
     * @var array
     */
    private $filters;
    private $categories;

    protected function configure()
    {
        $this
            ->setName('app:busugd:import')
            ->setDescription('Импорт объектов капитального строительства из сервиса smart.mos.ru')
            ->addOption(
                self::OPTION__DAILY,
                'd',
                InputOption::VALUE_REQUIRED,
                'Ежедневный импорт true|false',
                true
            )
            ->addOption(
                self::OPTION__TYPE_INDEX,
                null,
                InputOption::VALUE_REQUIRED,
                'Индекс фильтра',
                0
            )
            ->addOption(
                self::OPTION__PAGE,
                null,
                InputOption::VALUE_REQUIRED,
                'Начальная страница',
                0
            )
            ->addOption(
                self::OPTION__LIMIT,
                null,
                InputOption::VALUE_REQUIRED,
                'Максимальное количество объектов для обработки',
                50
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $daily = $input->getOption(self::OPTION__DAILY);
        $page = (int)$input->getOption(self::OPTION__PAGE);
        $limit = (int)$input->getOption(self::OPTION__LIMIT);
        $indexFilter = (int)$input->getOption(self::OPTION__TYPE_INDEX);

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');


        $filtersLoad = $em->getRepository(ImportFilter::class)->findBy(['daily' => $daily]);
        $this->filters = [];
        foreach ($filtersLoad as $item) {
            $this->filters[] = json_decode($item->getFilter(), true);
        }

        $categories = $em->getRepository(ConstructionType::class)->findAll();
        $this->categories = [];
        foreach ($categories as $item) {
            $this->categories[] = $item->getCodeGroup();
        }

        $this->count = 0;
        $this->page = 0;

        $output->writeln('waiting for a response from the bus');

        $this->saveObjects($page, $limit, $output);
    }

    private function saveObjects($page, $limit, $output)
    {
        $response = $this->stepImport($page, $limit);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $logger = $this->getContainer()->get('logger');

        if ($response) {

            foreach ($response as $item) {
                try {
                    $em->beginTransaction();
                    /** @var Construction $construction */
                    // ищем объект строительства в базе по uniqueId или по object_id
                    $queryConstruction = $em->getRepository(Construction::class)->createQueryBuilder('u')
                        ->where('u.objectId = :object_id OR u.uniqueId = :unique_id ')
                        ->setParameter('object_id', $item->docHeader->id->ugdId)
                        ->setParameter('unique_id', $item->docHeader->id->uniqueId);

                    $construction = $queryConstruction->getQuery()->getOneOrNullResult();

                    // если объекта нет, то он новый.
                    if ($construction === null) {
                        $construction = new Construction();
                        $objectNew = true;
                    } else {
                        $objectNew = false;
                    }

                    // парсим данные объекта
                    $constructionData = Construction::extractDataFromBusResponse($item);

                    //если есть сопоставление категории объекта по коду, то записываем
                    $codeGroupInput = (int)preg_replace('/\s+/', '', $item->docContent->fno->codeObjFuncObj);
                    $construction_type = $em->getRepository('AppBundle:ConstructionType')->createQueryBuilder('category')
                        ->where('category.codeGroup LIKE :codeGroupInput')
                        ->setParameter('codeGroupInput', '%' . $codeGroupInput . '%')
                        ->getQuery()
                        ->getResult();

                    $customData = $construction->getCustomData();

                    $objectStatus = $constructionData->getObjectStatus() ?: $construction->getData()->getObjectStatus();
                    if (array_key_exists($objectStatus, ConstructionStatus::$ObjectStatusTranslationMap)) {
                        $customData->setObjectStatus(ConstructionStatus::$ObjectStatusTranslationMap[$objectStatus]);
                        $construction->setCustomData($customData);
                    }

                    if ($construction_type) {
                        $customData->setMainFunctional($construction_type[0]->getAlias());
                        $construction->setCustomData($customData);
                    } else {
                        $output->writeln(sprintf('is no categories for Object: %s', $item->docHeader->id->uniqueId));
                        continue;
                    }


                    if ($constructionData->getMainFunctional() && $constructionData->getObjectStatus()) {
                        $construction->setPublishable(true);
                    }

                    $constructionData->setObjectId($item->docHeader->id->ugdId);
                    $construction->setUniqueId($item->docHeader->id->uniqueId);

                    $planDateEnd = $construction->parsePlanDateFromBusResponse($item, 'planDateEnd');
                    $factDateEnd = $construction->parsePlanDateFromBusResponse($item, 'factDateEnd');
                    $planDateInput = $construction->parsePlanDateFromBusResponse($item, 'planDateInput');
                    $factDateInput = $construction->parsePlanDateFromBusResponse($item, 'factDateInput');
                    $planDateStart = $construction->parsePlanDateFromBusResponse($item, 'planDateStart');
                    $factDateStart = $construction->parsePlanDateFromBusResponse($item, 'factDateStart');

                    if ($planDateEnd) {
                        $construction->setPlanDateEnd($planDateEnd);
                    }
                    if ($factDateEnd) {
                        $construction->setFactDateEnd($factDateEnd);
                    }
                    if ($planDateInput) {
                        $construction->setPlanDateInput($planDateInput);
                    }
                    if ($factDateInput) {
                        $construction->setFactDateInput($factDateInput);
                    }
                    if ($planDateStart) {
                        $construction->setPlanDateStart($planDateStart);
                    }
                    if ($factDateStart) {
                        $construction->setFactDateStart($factDateStart);
                    }

                    $construction->setEndYearFromBusResponse($item);
                    $construction->setStartYearFromBusResponse($item);

                    if ($objectNew) {
                        $output->writeln(sprintf('Object is new: %s', $construction->getUniqueId()));

                        $construction->setNew(true);
                        $construction->setUpdated(false);

                        $organization = $this->getContainer()->get('app.construction.find_organization')->getOrganization($construction);
                        if ($organization instanceof Organization) {
                            $construction->setOrganization($organization);
                        }

                        $construction->setData($constructionData);
                        $construction->setPendingData($constructionData);
                        $construction->acceptPendingData();
                        $construction->assignObjectId();

                    } else if (
                        $construction->getUniqueId() === null ||
                        $constructionData->getUpdateDateTime() > $construction->getObjectUpdateDateTime()
                    ) {

                        $output->writeln(sprintf('Object is updated: %s', $construction->getUniqueId()));

                        $construction->setNew(false);
                        $construction->setUpdated(true);

                        $construction->setPendingData($constructionData);
                        $construction->acceptPendingData();
                        $construction->assignObjectId();
                    } else {
                        $output->writeln(sprintf('Object is actual: %s', $construction->getUniqueId()));
                    }

                    $em->persist($construction);
                    $em->flush($construction);

                    $em->getConnection()->commit();
                    ++$this->count;

                } catch (Exception $e) {
                    $em->getConnection()->rollBack();

                    $logger->addCritical(printf(
                        "Error message was: %s.\nIn file: %s:%s\nError in object uniqueId %s\n\n",
                        $e->getMessage(),
                        $e->getFile(),
                        $e->getLine(),
                        $item->docHeader->id->uniqueId
                    ));

                    die;
                }
            }

            if (count($response) === $limit) {
                ++$this->page;
                $output->writeln(sprintf('Next filter: %s, page: %s, count: %s', $this->filter, $this->page, $this->count));
                $output->writeln('Pause in 10 seconds');
                sleep(10);
                return $this->saveObjects($this->page, $limit, $output);
            }

            if (count($response) < $limit) {
                ++$this->filter;
                $this->page = 0;

                if (isset($this->filters[$this->filter])) {
                    $output->writeln(sprintf('Next filter: %s, page: %s, count: %s', $this->filter, $this->page, $this->count));
                    $output->writeln('Pause in 10 seconds');
                    sleep(10);
                    return $this->saveObjects($this->page, $limit, $output);
                }

                $output->writeln(sprintf('%u objects processed', $this->count));
            }

            $output->writeln('Import success full');

            return true;

        }

        $output->writeln('Response is empty');
        return false;
    }

    protected function stepImport($page = 0, $limit = 50)
    {
        $api = new BusUgd(
            $this->getContainer()->getParameter('bus_ugd_smart.base_url'),
            $this->getContainer()->getParameter('bus_ugd_smart.login'),
            $this->getContainer()->getParameter('bus_ugd_smart.password')
        );

        $response = $api->objects->where($this->filters[$this->filter]);
        $response = $response->get($page, $limit);

        if (is_array($response) || is_object($response)) {
            return $response;
        }

        return false;
    }
}

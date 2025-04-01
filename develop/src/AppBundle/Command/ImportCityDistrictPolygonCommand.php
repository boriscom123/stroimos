<?php
namespace AppBundle\Command;

use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Construction;
use CrEOF\Geo\WKT\Parser;
use CrEOF\Spatial\PHP\Types\Geometry\MultiPolygon;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCityDistrictPolygonCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function configure()
    {
        $this
            ->setName('app:import:city-district-polygon')
            ->setDescription('Импорт меню')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $this->entityManager->getRepository('AppBundle:CityDistrict');
        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');
        $skipFirst = true;
        $wktParser = new Parser();
        if (($handle = fopen($rootDir . '/Resources/data/municipality_stroymos_wkt.csv', 'r')) !== false) {
            while(($cd = fgetcsv($handle, 0, ';')) !== false) {
                if($skipFirst === true) {
                    $skipFirst = false;
                    continue;
                }
                /** @var CityDistrict $district */
                $district = $repo->findOneBy(['id' => $cd[0]]);
                if($district) {
                    $wkt = $wktParser->parse($cd[1]);
                    $district->setPolygon(new MultiPolygon($wkt['value']));
                }

                $this->entityManager->flush();
            }

            fclose($handle);
        }

        $constructions = $this->entityManager->getRepository('AppBundle:Construction')->findAll();
        $total = count($constructions);
        $output->writeln('Total constructions: ' . $total);
        foreach ($constructions as $c) {
            /** @var Construction $c */
            $coordinates = explode(',', $c->getData()->getPointXyGeometryCoordinates());
            if(count($coordinates) === 2) {
                $c->setPoint(new Point($coordinates[0], $coordinates[1]));
            }
            $output->writeln('Constructions to go: ' . --$total);
        }
        $this->entityManager->flush();
    }
}

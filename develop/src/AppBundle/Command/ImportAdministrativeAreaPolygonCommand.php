<?php
namespace AppBundle\Command;

use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Construction;
use CrEOF\Geo\WKT\Parser;
use CrEOF\Spatial\PHP\Types\Geometry\MultiPolygon;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportAdministrativeAreaPolygonCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function configure()
    {
        $this
            ->setName('app:import:administrative-area-polygon')
            ->setDescription('Импорт границ административный районов')
        ;
    }

    protected function parseAndSavePolygon() {
        $repo = $this->entityManager->getRepository(AdministrativeArea::class);
        $rootDir = $this->getContainer()->getParameter('kernel.root_dir');
        $skipFirst = true;
        $wktParser = new Parser();
        if (($handle = fopen($rootDir . '/Resources/data/district_site-1.csv', 'r')) !== false) {
            while(($cd = fgetcsv($handle, 0, ';')) !== false) {
                if($skipFirst === true) {
                    $skipFirst = false;
                    continue;
                }
                /** @var AdministrativeArea $area */
                $area = $repo->findOneBy(['id' => $cd[0]]);
                if($area) {
                    $wkt = $wktParser->parse($cd[1]);
                    $area->setPolygon(new MultiPolygon($wkt['value']));
                }

                $this->entityManager->flush();
            }

            fclose($handle);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->parseAndSavePolygon();
    }
}

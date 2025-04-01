<?php
namespace ApiBundle\PresentationLayer\Xlsx;

use Application\Sonata\MediaBundle\Entity\Media;
use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;

class InforgaphicsXlsx
{
    /**
     * @var int
     */
    private $flushThreshold = 1000;
    /**
     * @var string
     */
    private $outputType = Type::XLSX;
    private $container;

    public function __construct($container)
    {
        $this->writer = WriterFactory::create($this->outputType);
        $this->container = $container;
    }

    public function __invoke(\Iterator $iterator)
    {
        $this->writer->openToBrowser("report.{$this->outputType}");
        $iterator->rewind();
        $headers = [
            'ID',
            'Заголовок',
            'Дата и время создания',
            'Ccылка на редактирование',
            'Автор',
        ];
        $this->writer->addRow($headers);

        while ($row = $iterator->current()) {
            $formatedRow = $this->buildFormattedRow($row[0]);
            $this->writer->addRow($formatedRow);
            $iterator->next();
        }

        $this->writer->close();
    }

    protected function buildFormattedRow(Media $rawData)
    {
        $data = [
            $rawData->getId(),
            $rawData->getName(),
            $rawData->getCreatedAt()->format('d.m.Y H:i'),
            $rawData->getAuthorName(),
            $this->container->get('sonata.media.admin.media')->generateUrl(
                'edit',
                ['id' => $rawData->getId()]
            ),
        ];

        return $data;
    }
}

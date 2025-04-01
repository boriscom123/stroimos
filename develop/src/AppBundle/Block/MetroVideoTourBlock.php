<?php
namespace AppBundle\Block;

use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Video;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MetroVideoTourBlock extends BaseBlockService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @param EntityManager $em
     */
    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        $settingsBuilder = $this->formFactory->createBuilder();

        $settingsBuilder->add('videos', 'sonata_type_native_collection', [
            'type' => 'metro_video_tour_item',
            'allow_add' => true,
            'allow_delete' => true,
        ]);

        $form
            ->with('Данные')
                ->add('settings', 'sonata_type_immutable_array', array(
                    'label' => false,
                    'keys' => $settingsBuilder,
                ))
            ->end()
        ;
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'template' => ':Metro:block/metro_vitdeo_tour.html.twig',
        ]);
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $rawVideos = $blockContext->getBlock()->getSetting('videos', []);

        $videos = [];

        $metroStation = $this->em->getRepository('AppBundle:MetroStation');
        $videoStation = $this->em->getRepository('AppBundle:Video');

        foreach ($rawVideos as $rawVideo) {
            $video = [
                'video' => $videoStation->find($rawVideo['video_id']),
                'metro' => $metroStation->find($rawVideo['metro_station_id']),
            ];

            if (!isset($video['video'], $video['metro'])) {
                continue;
            }

            $videos[] = $video;
        }

        if (empty($videos)) {
            return $response ?: new Response();
        }

        return $this->renderResponse($blockContext->getTemplate(), [
            'videos' => $videos,
        ]);
    }
}

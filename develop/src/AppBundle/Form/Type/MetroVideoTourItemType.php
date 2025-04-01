<?php
namespace AppBundle\Form\Type;


use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Video;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class MetroVideoTourItemType extends AbstractType
{
    use ContainerAwareTrait;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('video_id', 'entity', [
                'label' => 'Видео',
                'class' => Video::class,
            ])
            ->add('metro_station_id', 'entity', [
                'label' => 'Станция метро',
                'class' => MetroStation::class,
            ]);

        $builder->addModelTransformer(new CallbackTransformer(function ($data) {
            if (!isset($data)) {
                return null;
            }

            return [
                'video_id' => $this->container->get('doctrine')->getRepository('AppBundle:Video')->find($data['video_id']),
                'metro_station_id' => $this->container->get('doctrine')->getRepository('AppBundle:MetroStation')->find($data['metro_station_id'])
            ];
        }, function ($data) {
            if (!isset($data)) {
                return null;
            }

            return [
                'video_id' => $data['video_id']->getId(),
                'metro_station_id' => $data['metro_station_id']->getId()
            ];
        }));
    }

    public function getName()
    {
        return 'metro_video_tour_item';
    }
}

<?php
namespace AppBundle\Controller\Admin;

use AppBundle\Entity\MetroTimelineYear;
use Application\Sonata\MediaBundle\Entity\Media;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MetroTimelineYearCRUDController extends Controller
{
    public function batchUploadAction()
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('mode', 'choice', [
                'label' => 'Режим',
                'choices' => [
                    'update' => 'Обновить',
                    'replace' => 'Заменить всё (удалить текущие схемы и заменить новыми)',
                ]
            ])
            ->add('images', 'file', [
                'label' => 'Схемы',
                'multiple' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\All([
                        'constraints' => [
                            new Assert\Image([
                                'maxSize' => '1Mi',
                                'mimeTypes' => 'image/png',
                            ]),
                            new Assert\Callback([
                                'callback' => function (UploadedFile $image, ExecutionContextInterface $context) {
                                    if (null !== $this->extractYearFromFileName($image->getClientOriginalName())) {
                                        return;
                                    }

                                    $context->addViolation(sprintf('В имени файла "%s" не найден год', $image->getClientOriginalName()));
                                },
                            ])
                        ]
                    ])
                ]
            ])
            ->getForm();

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            if ($isFormValid) {
                try {
                    $this->updateMetroTimeline(
                        $form->get('mode')->getData(),
                        $form->get('images')->getData()
                    );

                    $this->addFlash('sonata_flash_success', 'Пакетная загрузка прошла успешно.');

                    return new RedirectResponse($this->admin->generateUrl('list'));
                } catch (\Exception $e) {
                    $isFormValid = false;
                }
            }

            if (!$isFormValid) {
                $this->addFlash('sonata_flash_error', 'Во время загрузки произошла ошибка.');
            }
        }

        return $this->render(':Admin/MetroTimelineYear:batch_upload.html.twig', array(
            'action' => 'batch_upload',
            'admin' => $this->admin,
            'form' => $form->createView()
        ));
    }

    private function extractYearFromFileName($fileName)
    {
        if (!preg_match('/\d{4}/', $fileName, $matches)) {
            return null;
        }

        return (integer)$fileName;
    }

    /**
     * @param string $mode
     * @param UploadedFile[] $images
     * @throws \Exception
     */
    private function updateMetroTimeline($mode, array $images)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->beginTransaction();
        $mediaManager = $this->get('sonata.media.manager.media');
        try {
            $repo = $em->getRepository(MetroTimelineYear::class);
            $replace = 'replace' === $mode;

            if ($replace) {
                $em->createQueryBuilder()
                    ->delete(MetroTimelineYear::class)
                    ->getQuery()
                    ->execute();
            }

            foreach ($images as $image) {
                $year = $this->extractYearFromFileName($image->getClientOriginalName());

                $mTMY = $replace
                    ? null
                    : $repo->findOneBy(['year' => $year]);

                if (!isset($mTMY)) {
                    $mTMY = new MetroTimelineYear();
                    $mTMY->setYear($year);
                } elseif ($mTMY->getImage()) {
                    $mediaManager->delete($mTMY->getImage(), false);
                }

                $imageMedia = new Media();
                $imageMedia->setBinaryContent($image);
                $imageMedia->setProviderName('sonata.media.provider.image');
                $imageMedia->setContext('metro_timeline');
                $imageMedia->setEnabled(true);

                $mTMY->setImage($imageMedia);
                $mTMY->setPublishable(true);

                $em->persist($mTMY);
            }

            $em->flush();
            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }
}

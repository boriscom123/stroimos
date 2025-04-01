<?php
namespace AppBundle\Admin\Extension;

use AppBundle\Admin\BaseAdmin;
use AppBundle\Entity\Owner;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;

class OwnersExtension extends AdminExtension
{
    /**
     * @inheritdoc
     */
    public function configureFormFields(FormMapper $form)
    {
        $admin = $form->getAdmin();
        $queryBuilder = null;
        if($admin instanceof BaseAdmin) {
            if($owner = $admin->getUserOwner()) {
                $queryBuilder = function (EntityRepository $er) use ($owner) {
                    $qb = $er->createQueryBuilder('o');
                    $qb->andWhere($qb->expr()->in('o.name', ':allowed'))
                        ->setParameter('allowed', [Owner::OWNER_STROI_MOS, $owner->getName()]);

                    return $qb;
                };
            }
        }

        if (!$form->has('owners')) {
            $form->add('owners', null, [
                'required' => true,
                'multiple' => true,
                'choice_translation_domain' => true,
                'query_builder' => $queryBuilder
            ]);
        }
    }
}

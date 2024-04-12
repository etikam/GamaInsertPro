<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\TypeOffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEntreprise')
            ->add('nomOffre')
            ->add('Description')
            ->add('email')
            ->add('telephone')
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateLimite', null, [
                'widget' => 'single_text',
            ])
            ->add('image')
            ->add('fk_typeOffre', EntityType::class, [
                'class' => TypeOffre::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\EtudiantNotActivate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantNotActivateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('genre')
            ->add('handicape')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('paysResidence')
            ->add('adresse')
            ->add('encours')
            ->add('niveau')
            ->add('matricule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtudiantNotActivate::class,
        ]);
    }
}

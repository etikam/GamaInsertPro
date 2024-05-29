<?php

namespace App\Form;

use App\Entity\Concentration;
use App\Entity\Etudiant;
use App\Entity\Postulation;
use App\Entity\Temoignage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('email')
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
            ->add('status')
            ->add('active')
            ->add('temoignage', EntityType::class, [
                'class' => Temoignage::class,
                'choice_label' => 'id',
            ])
            ->add('postulation', EntityType::class, [
                'class' => Postulation::class,
                'choice_label' => 'id',
            ])
            ->add('concentration', EntityType::class, [
                'class' => Concentration::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Demande1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('exp')
            ->add('description')
            ->add('location')
            ->add('expire')
            ->add('type')
            ->add('salairemin')
            ->add('salairemax')
            ->add('qualification')
            ->add('sex')
            ->add('city')
            ->add('categorie')
            ->add('created_at')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}

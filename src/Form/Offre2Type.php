<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Offre2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('autres')
            ->add('responsibilities')
            ->add('eduexp')
            ->add('expire')
            ->add('categorie')
            ->add('type')
            ->add('salairemin')
            ->add('salairemax')
            ->add('exp')
            ->add('qualification')
            ->add('sex')
            ->add('city')
            ->add('created_at')
            ->add('User')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}

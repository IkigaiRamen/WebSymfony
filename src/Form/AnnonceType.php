<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('location')
            ->add('type')
            ->add('exp')
            ->add('salairemin')
            ->add('salairemax')
            ->add('qualification')
            ->add('sex')
            ->add('description')
            ->add('eduexp')
            ->add('responsibilities')
            ->add('autres')
            ->add('country')
            ->add('city')
            ->add('expire')
            ->add('created_at')
            ->add('categorie')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('datecreation')
            ->add('datemodification')
            ->add('job')
            ->add('siteweb')
            ->add('lastname')
            ->add('firstname')
            ->add('numTel')
            ->add('exp')
            ->add('etat')
            ->add('sex')
            ->add('qualification')
            ->add('titre1')
            ->add('institut1')
            ->add('periode1')
            ->add('description1')
            ->add('titre2')
            ->add('institut2')
            ->add('periode2')
            ->add('description2')
            ->add('work1')
            ->add('company1')
            ->add('workperiod1')
            ->add('workdescription1')
            ->add('work2')
            ->add('company2')
            ->add('qualification1')
            ->add('qualification2')
            ->add('qualification3')
            ->add('qualification4')
            ->add('societe')
            ->add('workperiod2')
            ->add('workdescription2')
            ->add('video')
            ->add('bio')
            ->add('city')
            ->add('image')
            ->add('update_at')
            ->add('postule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Test;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TypeTextType::class ,['attr' => [
                'class' => "form-control"
            ]])
            //->add('type')
            //->add('maxscore')
            ->add('nbrtentative' , TypeTextType::class ,['attr' => [
                'class' => "form-control"
            ]])
            ->add('duree', TypeTextType::class ,['attr' => [
                'class' => "form-control"
            ]])
            //->add('datecreation')
            //->add('datemodification')
            //->add('iduser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}

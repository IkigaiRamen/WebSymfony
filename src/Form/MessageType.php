<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\User;
use App\Entity\Friends;
use Vich\UploaderBundle\Form\Type\VichFileType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('message', TextareaType::class, [
            "attr" => [
                "class" => "form-control"
            ]
        ])
        ->add('recipient', EntityType::class, [
            "class" => Friends::class,
            "choice_label" => "email",
            "attr" => [
                "class" => "form-control"
            ]
        ])

        ->add('contractFile', VichFileType::class, [
            'required' => false,
            'allow_delete' => true,
            'delete_label' => '...',
            'download_uri' => '...',
            'download_label' => '...',
            'asset_helper' => true,
        ])

        ->add('envoyer', SubmitType::class, [
            "attr" => [
                "class" => "btn btn-primary"
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}

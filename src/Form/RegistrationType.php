<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Component\InputType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', InputType::class, [
                "label" => "Email :",
                "placeholder" => "ex : jean-eude@email.com"
            ])
            ->add('password', InputType::class, [
                "type" => "password",
                "label" => "Mot de passe :"
            ])
            ->add('lastname', InputType::class, [
                "label" => "Nom :",
                "placeholder" => "ex : Du Champion"
            ])
            ->add('firstname', InputType::class, [
                "label" => "Prénom :",
                "placeholder" => "ex : Jean Eude"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf'
        ]);
    }
}
<?php

namespace App\Form\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InputType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['type' => 'text', 'placeholder' => '']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['type'] = $options['type'];
        $view->vars['placeholder'] = $options['placeholder'];
    }

    public function getParent()
    {
        return TextType::class;
    }
}
<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratePokemonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Type\TextType::class, [
                'mapped' => false,
                'required' => true
            ])
            ->add('level', Type\TextType::class, [
                'mapped' => false,
                'required' => true
            ])
            ->add('submit', Type\SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ],
                'label' => 'Generate'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}

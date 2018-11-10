<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', Type\TextType::class, [
                'attr' => [
                    'placeholder' => 'Imię trenera (login)'
                ],
                'label' => 'Imię trenera*',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Pole loginu nie może być puste']),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 20,
                        'minMessage' => 'Login musi zawierać co najmniej 6 znaków',
                        'maxMessage' => 'Login musi zawierać najwyżej 20 znaków'
                    ])
                ]
            ])
            ->add('email', Type\EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'label' => 'Email*',
                'constraints' => new Assert\Email(['message' => 'Wprowadź prawidłową wartość emaila'])
            ])
            ->add('password', Type\RepeatedType::class, [
                'type' => Type\PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Hasło'
                    ],
                    'label' => 'Hasło*'
                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Powtórz hasło'
                    ],
                    'label' => 'Powtórz hasło'
                ],
                'invalid_message' => 'Pola hasła muszą być identyczne',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Wartość nie może być pusta']),
                    new Assert\Length(['min' => 8, 'minMessage' => 'Hasło musi zawierać co najmniej 8 znaków'])
                ]
            ])
            ->add('pokemon', Type\ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Bulbasaur' => 1,
                    'Charmander' => 4,
                    'Squirtle' => 7
                ],
                'label' => 'Pierwszy Pokemon',
                'invalid_message' => 'Błędny ID startera'
            ])
            ->add('regulations', Type\CheckboxType::class, [
                'label' => 'Akceptuję regulamin',
                'mapped' => false,
                'constraints' => new Assert\IsTrue(['message' => 'Zaakceptuj regulamin'])
            ])
            /*->add('recaptcha', EWZRecaptchaType::class, [
                'mapped'      => false,
                'constraints' => [
                    new RecaptchaTrue(['message' => 'Potwierdź, że nie jesteś botem'])
                ],
                'label' => false
                ])*/
            ->add('submit', Type\SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success'
                ],
                'label' => 'Rejestracja'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}

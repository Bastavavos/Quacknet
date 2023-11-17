<?php

namespace App\Form;

use App\Entity\Duck;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class DuckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('duckname', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Need pseudo']),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Minimum {{ limit }} carac.',
                        'max' => 25,
                        'maxMessage' => 'Max {{ limit }} carac.',
                    ]),
                    new Regex([
                        'pattern' => '~^[a-zA-Z0-9_.-]+$~',
                        'message' => 'Le pseudo ne doit contenir que des caractères alphanumériques non accentués et ".", "-" et "_".',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères.',
                        'max' => 4096,
                        'maxMessage' => 'Le mot de passe ne doit pas dépasser {{ limit }} caractères.',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Duck::class,
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class FrontUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            "label" => "Name",
            "attr" => [
                "placeholder" => "Nom de l'utilisateur"
            ]
        ])
        ->add('email', EmailType::class, [
            "label" => "Email",
            "attr" => [
                "placeholder" => "Mail de l'utilisateur"
            ]
            ])
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Ancien mot de passe',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les 2 mots de passe doivent être identiques',
                'mapped' => false,
                'required' => false,
                'first_options' => [
                    'label' => 'Nouveau mot de passe', 
                    'help' => "Il faut un mot de passe de 14 caractères avec au moins 1 majuscule, 1 minuscule, 1 chiffre et un caractère spécial"],
                'second_options' => ['label' => 'Retaper le nouveau mot de passe'],
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-.]).{14,}$/', "Il faut un mot de passe de 14 caractères avec au moins 1 majuscule, 1 minuscule, 1 chiffre et un caractère spécial")
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'sanitize_html' => true
        ]);
    }
}

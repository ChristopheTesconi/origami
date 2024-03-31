<?php

namespace App\Form;

use App\Entity\Origami;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OrigamiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                "label" => "Nom de L'origami"
            ])
            ->add('picture', TextType::class,[
                "label" => "Image de l'origami"
            ])
            // ->add('createdAt', DateType::class,[
            //     "label" => "Date de création de l'origami",
            //     'data_class' => null, // Permet d'accepter les objets DateTimeImmutable
            //     'input' => 'datetime_immutable', // Spécifiez l'input type
            // ])
            // ->add('updatedAt', DateType::class,[
            //     "label" => "Date de mise à jour de l'origami",
            //     'data_class' => null, // Permet d'accepter les objets DateTimeImmutable
            //     'input' => 'datetime_immutable', // Spécifiez l'input type
            // ])
            ->add('description', TextareaType::class,[
                "label" => "Description de l'origami"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Origami::class,
        ]);
    }
}

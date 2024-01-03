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
            ->add('picture')
            ->add('createdAt', DateType::class,[
                "label" => "Date de création de l'origami"
            ])
            ->add('updatedAt', DateType::class,[
                "label" => "Date de mise à jour de l'origami"
            ])
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

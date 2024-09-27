<?php

namespace App\Form;

use App\Entity\Origami;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
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
                "label" => "Nom de l'origami"
            ])
            ->add('pictures', DropzoneType::class,[
                'label' => 'Photo de l\'origami, 2 MB max',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',  // Pour accepter uniquement les images
                    'multiple' => 'multiple',
                    'max' => 3               // Limite à 3 fichiers
                ],
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
            'csrf_protection' => true,
            'sanitize_html' => true
        ]);
    }
}

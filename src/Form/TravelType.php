<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Travel;
use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class TravelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom du voyage est obligatoire"
                    ]),
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "La description est obligatoire"
                    ]),
                ]
            ])
            //->add('slug')
            ->add('price', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le prix est obligatoire",
                    ]),
                    new Positive([
                        'message' => "Le prix doit être positif"
                    ])
                ]
            ])
            ->add('days', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le nombre de jours est obligatoire",
                    ]),
                    new Positive([
                        'message' => "Le nombre de jours doit être positif"
                    ])
                ]
            ])
            ->add('poster', FileType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le poster est obligatoire",
                    ]),
                    new Image([
                        'mimeTypes' => [ 'image/jpeg' ],
                        'mimeTypesMessage' => "L'image doit être au format jpg"
                    ])
                ]
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => "Le pays est obligatoire",
                    ]),
                ]
            ])
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => "Le thème est obligatoire"
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travel::class,
        ]);
    }
}

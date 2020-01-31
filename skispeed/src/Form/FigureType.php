<?php

namespace App\Form;

use App\Entity\Figure;
use App\Form\ImageType;
use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name', 
            'attr' => ['placeholder' => 'Name of the trick'],
            'constraints' => [new NotBlank(['message' => 'Please enter the name'])]])
            
            ->add('description', TextareaType::class, ['label' => 'Description',
            'attr' => ['placeholder' => 'Description of the trick'],
            'constraints' => [new NotBlank(['message' => 'Please enter the description']),
                new Length(['max' => 1500, 'maxMessage' => 'the message cannot contain more than 1500 digits'])]])
                
                
            ->add('images', CollectionType::class, [
                'entry_type'    => ImageType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'required'      => false,
                'by_reference'  => false,

                ])

            ->add('videos', CollectionType::class, [
                    'entry_type'    => VideoType::class,
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'prototype'     =>  true,
                    'required'      =>  false,
                    'by_reference'  =>  false
                ]
            )

            ->add('save', SubmitType::class, [
                'label' => 'Save the trick',
                 'attr'=> ['class'=>'btn btn-success submitButton'] 
                ] )
                
             ->add('cancel',
                    ButtonType::class,
                    [
                    'label' => "Cancel"
                    ]
                );


    }

     /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class
        ]);
    }
}

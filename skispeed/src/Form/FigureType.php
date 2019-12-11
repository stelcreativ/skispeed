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
            ->add('name', TextType::class, ['label' => 'Nom', 
            'attr' => ['placeholder' => 'Nom de la figure'],
            'constraints' => [new NotBlank(['message' => 'Veuillez saisir le nom'])]])
            
            ->add('description', TextareaType::class, ['label' => 'Description',
            'attr' => ['placeholder' => 'Description de la figure'],
            'constraints' => [new NotBlank(['message' => 'Veuillez saisir la description']),
                new Length(['max' => 1500, 'maxMessage' => 'Le message ne doit pas contenir plus de 1500 caractères'])]])

                ->add('image',FileType::class,array('data_class'=> null, 'label' => 'Image'))
                
                
            ->add('image', CollectionType::class, [
                'entry_type'    => ImageType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'by_reference'  => false,
                'mapped'  => false
                ])

            ->add('video', CollectionType::class, [
                    'entry_type'    => VideoType::class,
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'required'      =>  false,
                    'by_reference'  =>  false
                ]
            )

            ->add('save', SubmitType::class, array(
                'label' => 'Enregistrer la figure',
                 'attr'=> array('class'=>'btn btn-success submitButton') 
                 ))
;

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

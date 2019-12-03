<?php

namespace App\Form;

use App\Entity\Figure;
use App\Form\ImageType;
use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
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


                
            ->add('images', CollectionType::class, [
                'entry_type'    => ImageType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'by_reference'  => false,
                'mapped'  => false
                ])
            

            ->add('videos', CollectionType::class, [
                    'entry_type'    => VideoType::class,
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'required'      =>  false,
                    'by_reference'  =>  false
                ]
            )
            ->add('cancel', ButtonType::class, [
                'label' => "Annuler"
                ]);

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

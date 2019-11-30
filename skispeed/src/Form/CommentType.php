<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, ['label' => 'Laissez votre commentaire',
            'constraints' => [new NotBlank (['message' => 'Veuillez saisir un commentaire ']),
            new Length(['max' => 1500, 'maxMessage' => 'Votre message ne doit pas contenir plus de 1500 caractères']
            )]]);

            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}

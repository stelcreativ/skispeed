<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('password', RepeatedType::class, 
        [
            
            'type'=> PasswordType::class,
            'invalid_message' => 'les champs du mot de passe doivent être identiques',
            'first_options'=> [ 'label'=> 'Entrez le mot de passe' ],
            'second_options'=> [ 'label'=> 'Veuillez resaisir le mot de passe' ]
    
        ]) 
        ->add('submit', SubmitType::class,
        [ 'label'=> 'Réinitialiser le mot de passe']
        )
    
        
 ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

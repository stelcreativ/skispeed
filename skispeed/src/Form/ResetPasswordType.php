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
            'invalid_message' => 'The fields must be identical',
            'first_options'=> [ 'label'=> 'Enter Password' ],
            'second_options'=> [ 'label'=> 'Please retype password' ]
    
        ]) 
        ->add('submit', SubmitType::class,
        [ 'label'=> 'Reset Password']
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

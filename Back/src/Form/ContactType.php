<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,array(
                'attr' => [ 'require' => true, 'placeholder' => 'Pseudo',],))
            ->add('email', EmailType::class ,array('label'=> 'E-Mail','attr' => [ 'require' => true, 'placeholder' => 'E-Mail',],))

            ->add('objet', TextType::class ,array(
                'attr' => [ 'require' => true, 'placeholder' => 'Objet',],))
            ->add('message',  TextareaType::class  ,array(
                'attr' => [ 'require' => true, 'placeholder' => 'Message',],))
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

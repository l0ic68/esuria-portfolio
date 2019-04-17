<?php

namespace App\Form;

use App\Entity\Biographie;
use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class BiographieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('presentation')
            ->add('parcours')
            ->add('competence', EntityType::class, [
                "class" => "App\Entity\Skill",
                "choice_label" => "name",
                
                "expanded" => TRUE,
                "multiple" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biographie::class,
        ]);
    }
}

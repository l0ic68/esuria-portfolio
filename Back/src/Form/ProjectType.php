<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Technologies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('client')
            ->add('date')
            ->add('categorie', ChoiceType::class, [
                'choices'=> array(
                    'web' => 'web',
                    'photo' => 'photo',
                    'video' => 'video',
                    'montage' => 'montage',
                ),
                'expanded' => false,
                'multiple' => false,
                ])

            ->add('techno')
            ->add('URL_site')
            ->add('banner', ImageType::class, [
                // 'data_class' => null
                'required' => false,
            ])
            ->add('miniature', ImageType::class, [
                // 'data_class' => null
                'required' => false,
            ])
            ->add('gallery', CollectionType::class, [
                'entry_type' => ImageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'required' => false,
                // 'data_class' => null
            ])
            ->add('technologies', EntityType::class, [
                "class" => "App\Entity\Technologies",
                "choice_label" => "name",
                "expanded" => true,
                "multiple" => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices'=> array(
                    'fini' => 'fini',
                    'developpement' => 'developpement',
                    'Hors-ligne' => 'Hors-ligne',
                ),
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}

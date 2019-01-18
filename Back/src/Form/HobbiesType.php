<?php

namespace App\Form;

use App\Entity\Hobbies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class HobbiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link')
            ->add('type')
            ->add('imageFile', VichImageType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_label' => true,
            'download_uri' => true,
            'image_uri' => true,
            'imagine_pattern' => null,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                // 'data_class' => Hobbies::class,
            ]);
        }

}

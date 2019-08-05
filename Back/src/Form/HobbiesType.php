<?php

namespace App\Form;

use App\Entity\Hobbies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class HobbiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('link')
           ->add('image', ImageType::class, [
               'required' => false,
           ])
        //    ->add('brochure', FileType::class, ['label' => 'Brochure (PDF file)'])

            ;
}

    public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Hobbies::class,
            ]);
        }

}

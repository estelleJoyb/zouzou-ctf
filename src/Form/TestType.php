<?php

namespace App\Form;

use App\Entity\Test;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('flag', TextType::class, ['label' => 'Commentaire', 'required' => true])
            ->add('image', FileType::class, [
                'label' => 'image',
                'required' => false,
                'allow_file_upload' => true,
                'constraints' => new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => ['image/png'],
                    'mimeTypesMessage' => 'façon on en veut pas sur notre serveur on accepte de save que les .png'
                ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
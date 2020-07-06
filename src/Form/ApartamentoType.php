<?php

namespace App\Form;

use App\Entity\Apartamento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartamentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url')
            ->add('name')
            ->add('image')
            ->add('price')
            ->add('description')
            ->add('longDescription')
            ->add('latitud')
            ->add('longitud')
            ->add('active')
            ->add('possible')
            ->add('notes')
            //->add('createdAt')
            ->add('hash')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apartamento::class,
        ]);
    }
}

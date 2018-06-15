<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                "label" => 'Nom du produit'
            ])
            ->add('price', null, [
                "label" => "Prix",
                "attr" => [
                    "class" => "exotic"
                ]
            ])
            ->add('description')
            ->add('isPublished', null, [
                "label" => "Le produit doit-il être publié ?"
            ])
            /*->add('create', SubmitType::class, [
                "label" => "Créer le produit",
                "attr" => [
                    "class" => "btn btn-success"
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Pour avoir un liste déroulante de catégories
            ->add('categorie')
            // Pour un formulaire imbriqué
            //->add('categorie', CategoriesType::class)

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

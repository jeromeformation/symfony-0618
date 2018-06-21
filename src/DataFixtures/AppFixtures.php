<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Création d'une catégorie
        $category = new Categories();
        $category->setName('Confort');

        // Création de 300 produits
        for($i=0;$i<300;$i++) {
            // Attribution de valeurs à l'instance de produit
            $product = new Product();
            $product->setName('Hamac');
            $product->setDescription('Composé de tissu ou de plastique, le Hamac est facile à transporter. Il peut servir à se reposer ou passer un bon moment dans la forêt. Pensez à prendre des cordes pour l\'attacher ;)');
            $product->setPrice(15.99);
            $product->setCategorie($category);

            // Préparation de la requête SQL du produit courant
            $manager->persist($product);
        }

        // Exécution de l'ensemble des requêtes SQL
        $manager->flush();
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;

class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // On récupère les instances de fonctionnement de Faker
        $generator = \Faker\Factory::create('fr_FR');
        $populator = new Populator($generator, $manager);

        // On créé les données

        /****************************************************************/
        /*****                  LES CATEGORIES                     ******/
        /****************************************************************/
        $populator->addEntity(Categories::class, 20, [
            'name' => function() use ($generator) {
                return $generator->sentence(1);
            }
        ]);

        /****************************************************************/
        /*****                     LES PRODUITS                   ******/
        /****************************************************************/
        $populator->addEntity(Product::class, 300, [
            'price' => function() use ($generator) {
                return $generator->randomFloat(2, 0, 99999999.99);
            },
            'name' => function() use ($generator) {
                return $generator->sentence(3);
            },
            'description' => function() use ($generator) {
                return $generator->text(1500);
            }
        ]);

        // On sauvegarde les données
        $populator->execute();
    }
}


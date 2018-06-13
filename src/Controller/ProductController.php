<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  Classe de contrôleur gérant le CRUD des produits :
 *  - liste
 *  - détail
 *  - création
 *  - mis à jour
 *  - suppression
 */
class ProductController extends Controller
{
    /**
     * Tableau statique de produits
     * @var array
     */
    private $products = [
        [
            "id"            => 1,
            "name"          => 'hamac',
            "description"   => 'Pour se détendre lorsqu\'il arrêtera de pleuvoir'
        ],
        [
            "id"            => 2,
            "name"          => 'parasol',
            "description"   => 'Pour faire de l\'ombre au hamac'
        ],
        [
        "id"                => 3,
            "name"          => 'Le sable',
            "description"   => 'Pour tenir le parasol'
        ]
    ];

    /**
     * Liste les différents produits
     * @Route("/produits")
     * @return Response
     */
    public function index(): Response
    {
        // Récupération des produits
        $products = $this->products;

        // Renvoi des produits à la vue
        return $this->render('products/index.html.twig', [
                'products' => $products
            ]
        );
    }
}
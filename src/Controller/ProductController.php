<?php

namespace App\Controller;


use App\Entity\Product;
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
     * Liste les différents produits
     * @Route("/produits")
     * @return Response
     */
    public function index(): Response
    {
        /* Récupération des produits */
        // On récupère le Repository
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);
        // On récupère les produits
        $products = $repository->findAll();

        // Renvoi les produits à la vue
        return $this->render('products/index.html.twig', [
                'products' => $products
            ]
        );
    }

    /**
     * Ajoute un produit en BDD
     * @Route("/produits/ajout")
     * @return Response
     */
    public function add(): Response
    {
        // Création d'une instance de notre entité
        $product = new Product();

        // Attribution de données à l'entité
        $product->setName('Parasol');
        $product->setDescription('Pour faire de l\'ombre au hamac');
        $product->setPrice(155.99);

        // Récupération du manager de doctrine
        $manager = $this->getDoctrine()->getManager();
        // Enregistrement du produit en BDD
        $manager->persist($product);
        $manager->flush();

        return $this->redirectToRoute('app_product_index');
    }

    /**
     * Affiche le détail d'un produit
     * @Route("/produits/{id}", requirements={"id":"\d+"})
     * @param int $id id du produit à trouver (URL)
     * @return Response
     */
    public function show(int $id): Response
    {
        // Récupération du repository
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);

        // Récupération du produit
        $product = $repository->find($id);

        if(!$product) {
            throw $this->createNotFoundException("Produit non-trouvé dans ProductController::show($id)");
        }

        return $this->render(
            'products/show.html.twig',
            compact('product') // ["product" => $product]
        );
    }
}
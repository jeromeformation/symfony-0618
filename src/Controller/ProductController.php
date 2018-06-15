<?php

namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        // Création d'une instance de notre entité
        $product = new Product();

        // Récupération du formulaire
        $form = $this->createForm(ProductType::class, $product);

        /* Traitement du formulaire */
        // On "remplit" le formulaire avec les variables POST saisies
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // Formulaire ok

            // On récupère un objet de type "Product"
            $product = $form->getData();

            // Récupération du manager de doctrine
            $manager = $this->getDoctrine()->getManager();
            // Enregistrement du produit en BDD
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('app_product_show', [
                "id" => $product->getId()
            ]);
        }

        return $this->render('products/add.html.twig', [
            'createForm' => $form->createView()
        ]);
    }

    /**
     * Affiche le détail d'un produit
     * @Route("/produits/{id}", requirements={"id":"\d+"})
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return $this->render(
            'products/show.html.twig',
            compact('product') // ["product" => $product]
        );
    }

    /**
     * Modifie un produit en BDD
     * @Route("/produits/modification/{id}")
     * @param Product $product
     * @return Response
     */
    public function update(Product $product): Response
    {
        // Modifications du produit
        // ##todo : traiter le formulaire soumis
        $nbViews = $product->getNbViews();
        $product->setNbViews($nbViews + 1);

        // Enregistrement des modifications en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        // On redirige vers la page de détail
        // ##todo : afficher la vue du formulaire d'ajout
        return $this->redirectToRoute('app_product_show', [
            "id" => $product->getId()
        ]);
    }

    /**
     * Suppresion d'un produit en BDD
     * @Route("/produits/suppression/{id}")
     * @param Product $product
     * @return Response
     */
    public function remove(Product $product): Response
    {
        // Suppression du produit
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();

        // On redirige vers la liste des détail
        return $this->redirectToRoute('app_product_index');
    }
}
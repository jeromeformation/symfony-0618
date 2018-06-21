<?php

namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/produits/gestion/ajout")
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

            // Message de notification
            $this->addFlash('success', 'Votre produit a bien été ajouté');

            return $this->redirectToRoute('app_product_show', [
                "id" => $product->getId()
            ]);
        }

        return $this->render('products/form.html.twig', [
            'form'    => $form->createView(),
            'operation'     => 'Ajout',
            'operationBtn'  => 'Ajouter'
        ]);
    }

    /**
     * Affiche le détail d'un produit
     * @Route("/produits/{id}", requirements={"id":"\d+"})
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(int $id): Response
    {
        // Récupération du produit
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findOneWithCategory($id);

        if(!$product) {
            throw $this->createNotFoundException('Produit non-trouvé (show)');
        }

        // Modifications du produit
        $nbViews = $product->getNbViews();
        $product->setNbViews($nbViews + 1);

        // Enregistrement des modifications en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        return $this->render('products/show.html.twig', compact('product'));
    }

    /**
     * Modifie un produit en BDD
     * @Route("/produits/gestion/modification/{id}")
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function update(Product $product, Request $request): Response
    {
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

        return $this->render('products/form.html.twig', [
            'form'    => $form->createView(),
            'operation'     => 'Modification',
            'operationBtn'  => 'Modifier'
        ]);
    }

    /**
     * Suppresion d'un produit en BDD
     * @Route("/produits/gestion/suppression/{id}")
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

    /**
     * Test des requêtes SQL
     * @Route("/produits/sql")
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function sql(): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Product::class);

        // Récupération des produits
        $products = $repository->findBySQL();

        // On affiche les produits
        dump($products);
        die('Test SQL');
    }

    /**
     * Test des requêtes DQL
     * @Route("/produits/dql")
     * @return Response
     */
    public function dql(): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Product::class);

        // Récupération des produits
        $products = $repository->findByDQL();

        // Affichage des produits
        dump($products);
        die('Test DQL');
    }

    /**
     * Test du QueryBuilder
     * @Route("/produits/query-builder")
     * @return Response
     */
    public function queryBuilder(): Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Product::class);

        // Récupération des produits
        $products = $repository->findByQueryBuilder();

        // Affichage des produits
        dump($products);
        die('Test du QueryBuilder');
    }
}













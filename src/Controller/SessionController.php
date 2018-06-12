<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends Controller
{

    /**
     * Ajout d'une information en session
     * @Route("/session/add")
     * @return Response
     */
    public function add(SessionInterface $session): Response
    {
        /** L'UTILISATEUR SELECTIONNE 5 PRODUITS **/
        // Ajout d'une variable dans la session
        $session->set('nb-panier', 5);
        // Redirection vers la page d'accès des données de la session
        return $this->redirectToRoute('app_session_detailsession');
    }

    /**
     * Affiche l'élément "nb-panier" de la session
     * @Route("/session/detail")
     * @param SessionInterface $session
     * @return Response
     */
    public function detailSession(SessionInterface $session): Response
    {
        // Récupération du nombre de produis dans la panier
        $nbPanier = $session->get('nb-panier');

        // Envoi de la vue
        return $this->render('session/show.html.twig', [
            "nombresProduits" => $nbPanier
        ]);
    }

    /**
     * Page permettant de choisir le nombre de produits à ajouter dans la session
     * @Route("/produits/choix")
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function chooseNumber(Request $request, SessionInterface $session): Response
    {
        // Récupération du nombre saisi dans le formulaire (en POST)
        $nombre = $request->request->get('nombre');
        // On teste si le nombre n'est pas null
        if (!is_null($nombre)) {
            // Si le nombre n'est pas null, on l'ajoute dans la session
            $session->set('nb-panier', $nombre);
            // On redirige vers le détail de la session pour voir si le nombre a bien été ajouté en session
            return $this->redirectToRoute('app_session_detailsession');
        }

        // On envoie la vue du formulaire pour saisir un nombre
        return $this->render('produits/choose.html.twig');
    }

}

















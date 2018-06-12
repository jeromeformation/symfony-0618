<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * Classe de contrôleur pour tester les routes
 */
class HomeController extends Controller
{

    /**
     * On souhaite générer dans la page d'index, un lien vers le blog
     * On utilise donc la propriété qui stocke le générateur d'URL
     *
     * @return Response
     */
    public function index(): Response
    {
        // On génère l'URL
        $path = $this->generateUrl('app_home_blog', [
            "nombre" => 64,
            "theme" => 'detente'
        ]);

        // On créé la réponse (en passant le lien en paramètre)
        return $this->render('index.html.twig', [
            'lien' => $path
        ]);
    }

    /**
     * Cette méthode renvoie une vue TWIG
     *
     * @Route("/about")
     *
     * @return Response
     */
    public function about(): Response
    {
        // On retourne une réponse au navigateur
        // Cette réponse appelle une vue en lui passant un paramètre
        return $this->render('presentation/about.html.twig', [
            'prenom' => 'Billy'
        ]);
    }

    /**
     * Cette méthode sert à afficher un titre en HTML
     * @return Response
     */
    public function contact(): Response
    {
        // On créé une réponse
        $response = new Response('<h1>Page de contact</h1>');
        // On renvoit la réponse au navigateur
        return $response;
    }

    /**
     * Cette méthode sert à utiliser des paramètres dans l'URL avec des restrictions
     *
     * @Route("/blog/{theme}/{nombre}", requirements={
     *     "nombre" = "[0-9]+",
     *     "theme" = "[a-z]+"
     * })
     *
     * @param int $nombre Variable obligatoire de l'URL
     * @param string $theme Variable facultative de l'URL (valeur par défaut)
     * @return Response
     */
    public function blog(int $nombre, string $theme = 'Détente'): Response
    {
        return $this->render('blog/index.html.twig', [
            'title'  => 'Bienvenue sur le blog',
            'nbPage' => $nombre,
            'theme'    => $theme
        ]);
    }
}














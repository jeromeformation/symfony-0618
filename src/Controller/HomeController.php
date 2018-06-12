<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * Class HomeController
 * Classe de contrôleur pour tester les routes
 */
class HomeController
{

    /**
     * On stocke le générateur d'URL pour pouvoir l'utiliser dans les méthodes de la classe
     * @var UrlGeneratorInterface
     */
    private $urlGeneratorReceived;

    /**
     * On créé un constructeur pour pouvoir "injecter" une classe qui nous permettra de créer un lien
     * Cette classe devra implémenter "UrlGeneratorInterface"
     * Le principe de l'injection de dépendances :
     *      - On demande une classe (ou une interface)
     *      - "Symfony" (son container d'injection de dépendances) nous retourne,
     *        un objet instancié de cette classe
     *
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        // On attribue à notre propriété l'objet donné par "Symfony"
        $this->urlGeneratorReceived = $generator;
    }

    /**
     * On souhaite générer dans la page d'index, un lien vers le blog
     * On utilise donc la propriété qui stocke le générateur d'URL
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(Environment $twig): Response
    {
        // On génère l'URL
        $path = $this->urlGeneratorReceived->generate('app_home_blog', [
            "nombre" => 64,
            "theme" => 'detente'
        ]);

        // On créé la réponse (en passant le lien en paramètre)
        $response = new Response(
            $twig->render('index.html.twig', [
                'lien' => $path
            ])
        );

        // On renvoie la réponse au navigateur
        return $response;
    }


    /**
     * Cette méthode renvoie une vue TWIG
     *
     * @Route("/about")
     *
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function about(Environment $twig): Response
    {
        // On retourne une réponse au navigateur
        // Cette réponse appelle une vue en lui passant un paramètre
        return new Response(
            $twig->render('presentation/about.html.twig', [
                'prenom' => 'Billy'
            ])
        );
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
     * @param Environment $twig
     * @param int $nombre Variable obligatoire de l'URL
     * @param string $theme Variable facultative de l'URL (valeur par défaut)
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function blog(Environment $twig, int $nombre, string $theme = 'Détente'): Response
    {
        return new Response(
            $twig->render('blog/index.html.twig', [
                'title'  => 'Bienvenue sur le blog',
                'nbPage' => $nombre,
                'theme'    => $theme
            ])
        );
    }
}














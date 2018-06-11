<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController
{
    /**
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(Environment $twig): Response
    {
        $resultat = 42;

        $response = new Response(
            $twig->render('index.html.twig', [
                'nombre' => $resultat
            ])
        );

        return $response;
    }

    public function contact(): Response
    {
        $response = new Response('<h1>Page de contact</h1>');
        return $response;
    }

    /**
     * @Route("/about")
     * @param Environment $twig
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function about(Environment $twig): Response
    {
        return new Response(
            $twig->render('presentation/about.html.twig', [
                'prenom' => 'Jérôme'
            ])
        );
    }

    /**
     * @Route("/blog/{nombre}/{theme}", requirements={"nombre" = "[0-9]+","theme" = "[a-z]+"})
     * @param Environment $twig
     * @param $nombre
     * @param $theme
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














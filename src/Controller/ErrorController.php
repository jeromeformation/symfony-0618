<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends Controller
{
    /**
     * Génère systématiquement une erreur 404
     *
     * @Route("/not-found")
     *
     * @return Response
     */
    public function notFound(): Response
    {
        throw $this->createNotFoundException("Test de la page 404");
    }

    /**
     * Génère systématiquement une erreur 500
     *
     * @Route("/erreur-interne")
     *
     * @return Response
     * @throws \Exception
     */
    public function internalError(): Response
    {
        $response = $this->render('bundles/TwigBundle/Exception/error.html.twig');
        $response->setStatusCode(502);

        return $response;


        //return new Response('<h1>Testons</h1>', 502);

       //throw new \Exception("Test de l'erreur 502", 502);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 15/06/2018
 * Time: 11:22
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * Page d'accueil
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage(): Response
    {
        return $this->render('home.html.twig');
    }
}
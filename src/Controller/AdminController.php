<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * Page d'administration (seul les admins y ont accès)
     * @Route("/admin")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

}
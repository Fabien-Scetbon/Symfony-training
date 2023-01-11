<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $request): Response
    {
        // dd($request);
        $session = $request->getSession(); // comme session_start() en php
        if ($session->has( name: 'nbVisite')) {
            $nombreVisite = $session->get( name: 'nbVisite') + 1;
        } else {
            $nombreVisite = 1;
        }

        $session->set('nbVisite', $nombreVisite);

        return $this->render('session/index.html.twig',);
    }
}

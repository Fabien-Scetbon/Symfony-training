<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    // #[Route('/sayHello', name: 'say_hello')]
    // public function sayHello(): Response
    // {
    //     return $this->render('first/hello.html.twig',);

    // }

    #[Route('/sayHello/{name}', name: 'say_hello')]
    public function sayHelloName($name): Response
    {
        return $this->render('first/hello.html.twig', ['nom' => $name]);

    }
}

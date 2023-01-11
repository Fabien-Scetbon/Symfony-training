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

    #[Route('/sayHello/{name}', name: 'say.hello')]
    public function sayHelloName($name): Response
    {
        return $this->render('first/hello.html.twig', ['nom' => $name]);

    }

    #[Route('/multiplication/{nb1}/{nb2}/{name?Fabien}', name: 'multiplie_numbers')]
    public function multiplie($nb1, $nb2, $name): Response
    {
        $result = $nb1 * $nb2;
        return $this->render('first/hello.html.twig', ['result' => $result, 'nom' => $name]);
    }

    #[Route(
        '/multiplication2/{nb1}/{nb2}',  // '/multiplication2/{nb1<\d+>}/{nb2<\d+>}'  requirements raccourci
        name: 'multiplication',
        requirements: ['nb1' => '\d+', 'nb2' => '\d+']  // verifie param avant envoi avec regex (404 si pb)
        )]
    public function multiplie2($nb1, $nb2)
    {
        $result = $nb1 * $nb2;
        return new Response(content: "<h1>$result</h1>");
    }

}

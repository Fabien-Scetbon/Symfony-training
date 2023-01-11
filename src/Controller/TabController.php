<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nbNotes<\d+>?5}', name: 'app_tab')]
    public function index($nbNotes): Response
    {
        $notes = [];
        for ($i = 0; $i < $nbNotes; $i++) {
            $notes[] = rand(1, 1000);
        }
    
        return $this->render('tab/index.html.twig', [
            'notes'   => $notes,
        ]);
    }
}

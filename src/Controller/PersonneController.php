<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/personne/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response    // $doctrine ou autre nom
    {
        $entityManager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname( firstname: 'Fabien');
        $personne->setLastname( lastname: 'Scetb');
        $personne->setAge( age: '50');
        // champ job rempli plus tard

        // ajouter operation insertion dans la transaction
        $entityManager->persist($personne); // valable pour ajout ou modif suivant si l'id existe ou pas

        // execute la transaction
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [  // le gars du tuto a prefere refaire une page detail 
            'personne' => $personne,
        ]);
    }
}

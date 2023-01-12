<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/all', name: 'personne.all')]
    public function index(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository( persistentObject: Personne::class);
        $personnes = $repository->findAll();
        return $this->render('personne/index.html.twig',
        ['personnes' => $personnes]
    );
    }

    #[Route('/firstname/{firstname}', name: 'personne.firstname')]
    public function indexAll(ManagerRegistry $doctrine, $firstname): Response {
        $repository = $doctrine->getRepository( persistentObject: Personne::class);
        $personnes = $repository->findBy(
            ['firstname' => $firstname],
            ['age' => 'DESC']
        );
        return $this->render('personne/index.html.twig',
        ['personnes' => $personnes]
    );
    }

    #[Route('/page/{page?1}/{nb?10}', name: 'personne.page')]
    public function indexAllPage(ManagerRegistry $doctrine, $page, $nb): Response {
        $repository = $doctrine->getRepository( persistentObject: Personne::class);
        $nbPersonnes = $repository->count([]);  // erreur mais ça marche
        
        $personnes = $repository->findBy(
            [],
            limit: $nb,
            offset: $nb*($page - 1)
        );
        return $this->render('personne/index.html.twig',
        ['personnes' => $personnes]
    );
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    // public function detail(ManagerRegistry $doctrine, $id): Response {
    //     $repository = $doctrine->getRepository( persistentObject: Personne::class);
    //     $personne = $repository->find($id);

    // on utilise les params converter pour simplifier le code ci-dessus :

    public function detail(Personne $personne = null): Response {   // null si id n'existe pas

        if(!$personne) {
            $this->addFlash( type: 'error', message: "La personne n'existe pas");
        }

        return $this->render('personne/detail.html.twig',
        ['personne' => $personne]
    );
    }

    #[Route('/add', name: 'personne.add')]
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
        // on aurait pu ajouter d'autres personnes .....

        // execute la transaction
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [  // le gars du tuto a prefere refaire une page detail 
            'personne' => $personne,
        ]);
    }
}

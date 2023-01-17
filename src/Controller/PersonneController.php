<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/age/{ageMin}/{ageMax}', name: 'personne.age')]
    public function personneByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response {
        $repository = $doctrine->getRepository( persistentObject: Personne::class);
        $personnes = $repository->findPersonnesInAgeInterval($ageMin, $ageMax);  // erreur mais ça marche 
        return $this->render('personne/age.html.twig',
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
        $nbPages = ceil($nbPersonnes / $nb);

        $personnes = $repository->findBy(
            [],
            limit: $nb,
            offset: $nb*($page - 1)
        );

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbPages'   => $nbPages,
            'page'      => $page
        ]
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
    public function addPersonne(ManagerRegistry $doctrine): Response {  // $doctrine ou autre nom
        $manager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setFirstname( firstname: 'Popo');
        $personne->setLastname( lastname: 'Papa');
        $personne->setAge( age: '25');
        // champ job rempli plus tard

        // ajouter operation insertion dans la transaction
        $manager->persist($personne); // valable pour ajout ou modif suivant si l'id existe ou pas
        // on aurait pu ajouter d'autres personnes .....

        // execute la transaction
        $manager->flush();

        return $this->render('personne/detail.html.twig', [  // le gars du tuto a prefere refaire une page detail 
            'personne' => $personne,
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'personne.delete')]
    public function deletePersonne(Personne $personne = null, ManagerRegistry $doctrine): RedirectResponse {    // manager pour utiliser remove
    
        // Recuperer la personne
        if ($personne) {  // si personne existe, la sup et retourner flashMess
            
            $manager = $doctrine->getManager();

            // ajoute la fct de suppr dans la transaction
            $manager->remove($personne);

            // executer la transaction
            $manager->flush();
            $this->addFlash( type: 'success', message: "Suppression réussie");

        } else {
            $this->addFlash( type: 'error', message: "La personne n'existe pas");
        }

        return $this->redirectToRoute(route: 'personne.page');
    }

    #[Route('/update/{id<\d+>}/{firstname}/{lastname}/{age}', name: 'personne.update')]
    public function updatePersonne(Personne $personne = null, ManagerRegistry $doctrine, $firstname, $lastname, $age): RedirectResponse {    // manager pour utiliser remove
    
        // Recuperer la personne
        if ($personne) { 

            $personne->setFirstname($firstname);
            $personne->setLastname($lastname);
            $personne->setAge($age);
            
            $manager = $doctrine->getManager();

            $manager->persist($personne);  // add si id existe pas, update si id existe

            // executer la transaction
            $manager->flush();
            $this->addFlash( type: 'success', message: "Mise à jour réussie");

        } else {
            $this->addFlash( type: 'error', message: "La personne n'existe pas");
        }

        return $this->redirectToRoute(route: 'personne.page');
    }
}

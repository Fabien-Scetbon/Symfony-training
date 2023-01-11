<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/todos")] //prefixe pour toutes les routes qui suivent
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]  // '/todos'   sans prefixe
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has(name: 'todos')) {

            $todosList = [
                'achat' => 'clé USB',
                'voiture' => 'faire révision',
                'enfants' => 'ne pas en faire',
                'appart' => 'acheter canapé'
            ];

            $session->set('todos', $todosList);

            $this->addFlash(type: 'info', message: "La liste des todos vient d'être initialisée");
        }

        return $this->render('todo/index.html.twig');
    }

    // ajouter todo

    #[Route('/add/{cle}/{valeur}', name: 'todo.add')]
    public function addTodo(Request $request, $cle, $valeur): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has(name: 'todos')) {

            $todos = $session->get(name: 'todos');

            if (isset($todos[$cle])) {
                $this->addFlash(type: 'error', message: "Le todo avec la clé $cle existe déja");
            } else {
                $todos[$cle] = $valeur;
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "Le todo avec la clé $cle a été ajouté à la liste");
            }
        } else {

            $this->addFlash(type: 'error', message: "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute(route: 'app_todo');
    }

    // update todo

    #[Route('/update/{cle}/{valeur}', name: 'todo.update')]
    public function updateTodo(Request $request, $cle, $valeur): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has(name: 'todos')) {

            $todos = $session->get(name: 'todos');

            if (isset($todos[$cle])) {
                $todos[$cle] = $valeur;
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "Le todo avec la clé $cle a été mis à jour");
            } else {
                $this->addFlash(type: 'error', message: "Le todo avec la clé $cle n'existe pas");
            }
        } else {

            $this->addFlash(type: 'error', message: "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute(route: 'app_todo');
    }

    // delete todo

    #[Route('/delete/{cle}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $cle): RedirectResponse
    {

        $session = $request->getSession();

        if ($session->has(name: 'todos')) {

            $todos = $session->get(name: 'todos');

            if (isset($todos[$cle])) {
                unset($todos[$cle]);
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "Le todo avec la clé $cle a été supprimé");
            } else {
                $this->addFlash(type: 'error', message: "Le todo avec la clé $cle n'existe pas");
            }
        } else {

            $this->addFlash(type: 'error', message: "La liste des todos n'est pas encore initialisée");
        }

        return $this->redirectToRoute(route: 'app_todo');
    }

    // reset todo

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse
    {
        $session = $request->getSession();

        $session->remove( name: 'todos');

        return $this->redirectToRoute(route: 'app_todo');
    }
}

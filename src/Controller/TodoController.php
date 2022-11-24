<?php

namespace App\Controller;

use App\Form\TodoType;
use App\Entity\SymfonyTodo;
use App\Repository\SymfonyTodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface, SymfonyTodoRepository $symfonyTodoRepository): Response
    {
        $todo = new SymfonyTodo();
        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($todo);
            $entityManagerInterface->flush();
        }

        $todos = $symfonyTodoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            'myForm' => $form->createView(),
            "todos" => $todos
        ]);
    }

    // public function redirect()
    // {
        

    //     return $this->render('todo/index.html.twig', [
    //         "todos" => $todos
    //     ]);
    // }
}

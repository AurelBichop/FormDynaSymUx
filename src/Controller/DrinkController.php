<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Form\Drink1Type;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/drink')]
class DrinkController extends AbstractController
{
    #[Route('/', name: 'app_drink_index', methods: ['GET'])]
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->render('drink/index.html.twig', [
            'drinks' => $drinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_drink_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $drink = new Drink();
        $form = $this->createForm(Drink1Type::class, $drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($drink);
            $entityManager->flush();

            return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drink/new.html.twig', [
            'drink' => $drink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drink_show', methods: ['GET'])]
    public function show(Drink $drink): Response
    {
        return $this->render('drink/show.html.twig', [
            'drink' => $drink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_drink_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Drink $drink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Drink1Type::class, $drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drink/edit.html.twig', [
            'drink' => $drink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drink_delete', methods: ['POST'])]
    public function delete(Request $request, Drink $drink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$drink->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($drink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
    }
}

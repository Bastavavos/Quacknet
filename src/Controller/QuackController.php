<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/quack')]
class QuackController extends AbstractController
{
    #[Route('/', name: 'app_quack_index', methods: ['GET'])]
    public function index(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/index.html.twig', [
            'quacks' => $quackRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quack = new Quack();
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_quack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $quack = $entityManager->getRepository(Quack::class)->find($id);

        if (!$quack) {
            throw $this->createNotFoundException('No quack found for id ' . $id);
        }

        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack/edit.html.twig', [
            'quack' => $quack,
            'form' => $form,
            'id' => $quack->getId()
        ]);
    }

    #[Route('/delete/{id}', name: 'app_quack_delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $quack = $entityManager->getRepository(Quack::class)->find($id);

        if (!$quack) {
            throw $this->createNotFoundException('No quack found for id ' . $id);
        }

        $entityManager->remove($quack);
        $entityManager->flush();

        return $this->redirectToRoute('app_quack_index');
    }
}
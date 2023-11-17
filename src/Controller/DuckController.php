<?php

namespace App\Controller;

use App\Entity\Duck;
use App\Form\DuckType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DuckController extends AbstractController
{
    #[Route('/modify/{id}', name: 'app_duck_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $duck = $entityManager->getRepository(Duck::class)->find($id);

        if (!$duck) {
            throw $this->createNotFoundException('No duck found for id ' . $id);
        }

        $form = $this->createForm(DuckType::class, $duck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $duck = $form->getData();
            $duck->setPassword(
                $userPasswordHasher->hashPassword(
                    $duck,
                    $form->get('plainPassword')->getData()
                )
            );
            return $this->redirectToRoute('app_duck_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registration/updateAccount.html.twig', [
            'form' => $form,
        ]);
    }
}
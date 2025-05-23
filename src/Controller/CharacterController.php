<?php

namespace App\Controller;

use App\Entity\Character;
use App\Form\CharacterForm;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/character')]
final class CharacterController extends AbstractController
{
    #[Route(name: 'app_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $characterRepository->findAll(),
        ]);
    }

    #[Route('/character/new', name: 'app_character_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterForm::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $character->setUser($this->getUser());
            $character->setUser($this->getUser());
            $character->setRole('apply'); 
            $character->setGuild(null); 

            $entityManager->persist($character);
            $entityManager->flush();

            $referer = $request->headers->get('referer');
            return $this->redirect($referer ?? $this->generateUrl('app_select_character'));
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_character_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CharacterForm::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $character->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/character/{id}/leave-guild', name: 'app_character_leave_guild', methods: ['POST'])]
    public function leaveGuild(Character $character, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->getUser() !== $character->getUser()) {
            throw $this->createAccessDeniedException("Tu ne peux pas modifier un personnage qui ne t'appartient pas.");
        }

        $character->setGuild(null);
        $em->flush();

        $this->addFlash('success', 'Tu as quitté la guilde.');

        return $this->redirectToRoute('app_dashboard');
    }

}

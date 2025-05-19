<?php

namespace App\Controller;

use App\Entity\Guild;
use App\Entity\Character;
use App\Form\GuildForm;
use App\Repository\GuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/guild')]
final class GuildController extends AbstractController
{
    #[Route(name: 'app_guild_index', methods: ['GET'])]
    public function index(GuildRepository $guildRepository): Response
    {
        return $this->render('guild/index.html.twig', [
            'guilds' => $guildRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_guild_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guild = new Guild();
        $form = $this->createForm(GuildForm::class, $guild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guild);
            $entityManager->flush();

            return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guild/new.html.twig', [
            'guild' => $guild,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guild_show', methods: ['GET'])]
    public function show(Guild $guild): Response
    {
        return $this->render('guild/show.html.twig', [
            'guild' => $guild,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_guild_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guild $guild, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuildForm::class, $guild);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guild/edit.html.twig', [
            'guild' => $guild,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guild_delete', methods: ['POST'])]
    public function delete(Request $request, Guild $guild, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $guild->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($guild);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guild_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/guild/membres', name: 'app_guild_members')]
    public function members(Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $characterId ? $em->getRepository(Character::class)->find($characterId) : null;

        if (!$character || !$character->getGuild()) {
            $this->addFlash('error', 'Ce personnage n\'a pas de guilde.');
            return $this->redirectToRoute('app_dashboard');
        }

        $guild = $character->getGuild();
        $members = $em->getRepository(Character::class)->findBy(['guild' => $guild]);

        return $this->render('guild/members.html.twig', [
            'guild' => $guild,
            'members' => $members,
            'character' => $character,
        ]);
    }

    
}

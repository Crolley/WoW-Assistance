<?php

namespace App\Controller;

use App\Entity\Guild;
use App\Entity\JoinRequest;
use App\Entity\Character;
use App\Repository\GuildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/guild')]
class AvailableGuildsController extends AbstractController
{
    #[Route('/available', name: 'app_guild_available')]
    public function list(GuildRepository $guildRepository, Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || $character->getGuild()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $guilds = $guildRepository->findAll();

        return $this->render('guild/available.html.twig', [
            'guilds' => $guilds,
            'character' => $character,
        ]);
    }

    #[Route('/request/{id}', name: 'app_guild_request', methods: ['POST'])]
    public function requestJoin(Guild $guild, Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || $character->getGuild()) {
            return $this->redirectToRoute('app_dashboard');
        }

        $existing = $em->getRepository(JoinRequest::class)->findOneBy([
            'character' => $character,
            'guild' => $guild,
            'status' => 'pending'
        ]);

        if ($existing) {
            $this->addFlash('warning', 'Une demande est déjà en attente pour cette guilde.');
            return $this->redirectToRoute('app_guild_available');
        }

        $joinRequest = new JoinRequest();
        $joinRequest->setCharacter($character);
        $joinRequest->setGuild($guild);
        $joinRequest->setStatus('pending');

        $em->persist($joinRequest);
        $em->flush();

        $this->addFlash('success', 'Demande envoyée à la guilde !');
        return $this->redirectToRoute('app_guild_available');
    }
}

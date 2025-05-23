<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Guild;
use App\Entity\JoinRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JoinRequestController extends AbstractController
{
    #[Route('/guilds/request/{id}', name: 'app_guild_request', methods: ['POST'])]
    public function requestGuild(Guild $guild, Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || $character->getGuild()) {
            $this->addFlash('error', 'Vous ne pouvez pas postuler.');
            return $this->redirectToRoute('app_dashboard');
        }

        $existing = $em->getRepository(JoinRequest::class)->findOneBy([
            'character' => $character,
            'guild' => $guild,
            'status' => 'pending'
        ]);

        if ($existing) {
            $this->addFlash('info', 'Une demande est déjà en cours pour cette guilde.');
            return $this->redirectToRoute('app_guild_available');
        }

        $requestEntity = new JoinRequest();
        $requestEntity->setCharacter($character);
        $requestEntity->setGuild($guild);
        $requestEntity->setStatus('pending');

        $em->persist($requestEntity);
        $em->flush();

        $this->addFlash('success', 'Votre demande a bien été envoyée.');
        return $this->redirectToRoute('app_guild_available');
    }
}

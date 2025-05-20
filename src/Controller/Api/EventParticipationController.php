<?php

namespace App\Controller\Api;

use App\Entity\Character;
use App\Entity\Event;
use App\Entity\EventParticipation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/event')]
class EventParticipationController extends AbstractController
{
    #[Route('/{id}/participation', name: 'api_event_participation', methods: ['POST'])]
    public function setParticipation(Request $request, Event $event, EntityManagerInterface $em): JsonResponse
    {
        $status = $request->request->get('status');
        $validStatuses = ['accepted', 'declined'];

        if (!in_array($status, $validStatuses, true)) {
            return new JsonResponse(['error' => 'Statut invalide.'], 400);
        }

        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || $character->getGuild() !== $event->getGuild()) {
            return new JsonResponse(['error' => 'Non autorisé.'], 403);
        }

        $participation = $em->getRepository(EventParticipation::class)
            ->findOneBy(['event' => $event, 'character' => $character]);

        if (!$participation) {
            $participation = new EventParticipation();
            $participation->setEvent($event);
            $participation->setCharacter($character);
        }

        $participation->setStatus($status);
        $em->persist($participation);
        $em->flush();

        return new JsonResponse(['success' => true, 'status' => $status]);
    }
}

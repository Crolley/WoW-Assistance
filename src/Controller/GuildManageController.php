<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\JoinRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuildManageController extends AbstractController
{
    #[Route('/guild/manage', name: 'app_guild_manage')]
    public function manage(Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');
        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character || !in_array($character->getRole(), ['GM', 'RL', 'Officier'])) {
            $this->addFlash('error', 'Accès refusé.');
            return $this->redirectToRoute('app_dashboard');
        }

        $guild = $character->getGuild();
        $requests = $em->getRepository(JoinRequest::class)->findBy([
            'guild' => $guild,
            'status' => 'pending'
        ]);

        return $this->render('guild/manage.html.twig', [
            'guild' => $guild,
            'requests' => $requests,
        ]);
    }

    #[Route('/join-request/{id}/accept', name: 'app_join_request_accept', methods: ['POST'])]
    public function accept(JoinRequest $requestEntity, EntityManagerInterface $em): Response
    {
        $character = $requestEntity->getCharacter();
        $character->setGuild($requestEntity->getGuild());
        $requestEntity->setStatus('accepted');

        $em->flush();
        return $this->redirectToRoute('app_guild_manage');
    }

    #[Route('/join-request/{id}/refuse', name: 'app_join_request_refuse', methods: ['POST'])]
    public function refuse(JoinRequest $requestEntity, EntityManagerInterface $em): Response
    {
        $requestEntity->setStatus('refused');
        $em->flush();

        return $this->redirectToRoute('app_guild_manage');
    }
}

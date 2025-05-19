<?php

namespace App\Controller;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectCharacterController extends AbstractController
{
    #[Route('/select-character', name: 'app_select_character')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $characters = $em->getRepository(Character::class)->findBy(['user' => $user]);

        return $this->render('select_character/index.html.twig', [
            'characters' => $characters
        ]);
    }

    #[Route('/select-character/{id}', name: 'app_select_character_set')]
    public function setCharacter(Character $character, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('selected_character_id', $character->getId());

        return $this->redirectToRoute('app_dashboard');
    }
}

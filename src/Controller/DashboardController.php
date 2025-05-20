<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Character;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->getSession()->get('selected_character_id');

        if (!$characterId) {
            return $this->redirectToRoute('app_select_character');
        }

        $character = $em->getRepository(Character::class)->find($characterId);

        return $this->render('dashboard/index.html.twig', [
            'character' => $character,
        ]);
    }
}

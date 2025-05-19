<?php

namespace App\Controller\Api;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/character')] 
class CharacterController extends AbstractController
{
    #[Route('/{id}/role', name: 'api_change_role', methods: ['POST'])]
    public function changeRole(Request $request, Character $character, EntityManagerInterface $em): JsonResponse
    {
        $newRole = $request->request->get('role');

        $selectedId = $request->getSession()->get('selected_character_id');
        $currentCharacter = $em->getRepository(Character::class)->find($selectedId);

        $allowedRoles = ['GM', 'RL', 'Officier'];
        if (!$currentCharacter || !in_array($currentCharacter->getRole(), $allowedRoles, true)) {
            return new JsonResponse(['error' => 'Non autorisé'], 403);
        }
        
        $validRoles = array_values(\App\Entity\Character::ROLES);
        if (!in_array($newRole, $validRoles, true)) {
            return new JsonResponse(['error' => 'Rôle invalide'], 400);
        }

        $character->setRole($newRole);
        $em->flush();

        return new JsonResponse(['success' => true, 'newRole' => $newRole]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Loot;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/loot')]
class LootController extends AbstractController
{
    #[Route('/add', name: 'app_loot_add', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $characterId = $request->request->get('character_id');
        $type = $request->request->get('type');
        $nom = $request->request->get('nom');

        $character = $em->getRepository(Character::class)->find($characterId);

        if (!$character) {
            $this->addFlash('error', 'Personnage non trouvé.');
            return $this->redirectToRoute('app_guild_members');
        }

        $existingLoot = $em->getRepository(Loot::class)->findOneBy([
            'character' => $character,
            'type' => $type,
            'nom' => $nom,
        ]);

        if ($existingLoot) {
            $existingLoot->setCount($existingLoot->getCount() + 1);
        } else {
            $loot = new Loot();
            $loot->setCharacter($character);
            $loot->setType($type);
            $loot->setNom($nom);
            $loot->setCount(1);
            $em->persist($loot);
        }

        $em->flush();

        $this->addFlash('success', 'Loot ajouté avec succès.');
        return $this->redirectToRoute('app_guild_members');
    }
}

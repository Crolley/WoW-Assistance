<?php

namespace App\DataFixtures;

use App\Entity\Specialisation;
use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialisationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $specialisations = [
            'Guerrier' => [
                ['name' => 'Arms', 'role' => 'DPS'],
                ['name' => 'Fury', 'role' => 'DPS'],
                ['name' => 'Protection', 'role' => 'Tank'],
            ],
            'Mage' => [
                ['name' => 'Feu', 'role' => 'DPS'],
                ['name' => 'Givre', 'role' => 'DPS'],
                ['name' => 'Arcane', 'role' => 'DPS'],
            ],
            'Chasseur' => [
                ['name' => 'Précision', 'role' => 'DPS'],
                ['name' => 'Maîtrise des bêtes', 'role' => 'DPS'],
                ['name' => 'Survie', 'role' => 'DPS'],
            ],
            'Paladin' => [
                ['name' => 'Sacré', 'role' => 'Heal'],
                ['name' => 'Protection', 'role' => 'Tank'],
                ['name' => 'Vindicte', 'role' => 'DPS'],
            ],
            'Prêtre' => [
                ['name' => 'Discipline', 'role' => 'Heal'],
                ['name' => 'Sacré', 'role' => 'Heal'],
                ['name' => 'Ombre', 'role' => 'DPS'],
            ],
            'Voleur' => [
                ['name' => 'Assassinat', 'role' => 'DPS'],
                ['name' => 'Finesse', 'role' => 'DPS'],
                ['name' => 'Hors-la-loi', 'role' => 'DPS'],
            ],
            'Démoniste' => [
                ['name' => 'Destruction', 'role' => 'DPS'],
                ['name' => 'Démonologie', 'role' => 'DPS'],
                ['name' => 'Affliction', 'role' => 'DPS'],
            ],
            'Druide' => [
                ['name' => 'Équilibre', 'role' => 'DPS'],
                ['name' => 'Farouche', 'role' => 'DPS'],
                ['name' => 'Gardien', 'role' => 'Tank'],
                ['name' => 'Restauration', 'role' => 'Heal'],
            ],
            'Chaman' => [
                ['name' => 'Amélioration', 'role' => 'DPS'],
                ['name' => 'Élémentaire', 'role' => 'DPS'],
                ['name' => 'Restauration', 'role' => 'Heal'],
            ],
            'Chevalier de la mort' => [
                ['name' => 'Sang', 'role' => 'Tank'],
                ['name' => 'Givre', 'role' => 'DPS'],
                ['name' => 'Impie', 'role' => 'DPS'],
            ],
            'Moine' => [
                ['name' => 'Maître brasseur', 'role' => 'Tank'],
                ['name' => 'Tisse-brume', 'role' => 'Heal'],
                ['name' => 'Marche-vent', 'role' => 'DPS'],
            ],
            'Chasseur de démons' => [
                ['name' => 'Dévastation', 'role' => 'DPS'],
                ['name' => 'Vengeance', 'role' => 'Tank'],
            ],
            'Évocateur' => [
                ['name' => 'Augmentation', 'role' => 'DPS'],
                ['name' => 'Préservation', 'role' => 'Heal'],
                ['name' => 'Dévastation', 'role' => 'DPS'],
            ],
        ];

        foreach ($specialisations as $classeName => $specs) {
            $classe = $manager->getRepository(Classe::class)->findOneBy(['name' => $classeName]);
            if (!$classe) continue;

            foreach ($specs as $data) {
                $spec = new Specialisation();
                $spec->setName($data['name']);
                $spec->setRole($data['role']);
                $spec->setClasse($classe);
                $manager->persist($spec);
            }
        }

        $manager->flush();
    }
}

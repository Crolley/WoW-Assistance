<?php

namespace App\DataFixtures;

use App\Entity\Specialisation;
use App\Entity\Classe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClasseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $classes = [
            ['name' => 'Guerrier', 'color' => '#C79C6E', 'icon' => 'warrior.png'],
            ['name' => 'Mage', 'color' => '#69CCF0', 'icon' => 'mage.png'],
            ['name' => 'Chasseur', 'color' => '#ABD473', 'icon' => 'hunter.png'],
            ['name' => 'Voleur', 'color' => '#FFF569', 'icon' => 'rogue.png'],
            ['name' => 'Prêtre', 'color' => '#FFFFFF', 'icon' => 'priest.png'],
            ['name' => 'Démoniste', 'color' => '#9482C9', 'icon' => 'warlock.png'],
            ['name' => 'Druide', 'color' => '#FF7D0A', 'icon' => 'druid.png'],
            ['name' => 'Chaman', 'color' => '#0070DE', 'icon' => 'shaman.png'],
            ['name' => 'Paladin', 'color' => '#F58CBA', 'icon' => 'paladin.png'],
            ['name' => 'Chevalier de la mort', 'color' => '#C41F3B', 'icon' => 'dk.png'],
            ['name' => 'Moine', 'color' => '#00FF96', 'icon' => 'monk.png'],
            ['name' => 'Chasseur de démons', 'color' => '#A330C9', 'icon' => 'dh.png'],
            ['name' => 'Évocateur', 'color' => '#33937F', 'icon' => 'evoker.png'],
        ];

        foreach ($classes as $data) {
            $classe = new \App\Entity\Classe();
            $classe->setName($data['name']);
            $classe->setColor($data['color']);
            $classe->setIcon($data['icon']);
            $manager->persist($classe);
        }

        $manager->flush();
    }
}

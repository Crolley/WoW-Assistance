<?php

namespace App\DataFixtures;

use App\Entity\Guild;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GuildFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $guilds = [
            ['name' => 'Banished', 'faction' => 'Horde', 'serveur' => 'Ysondre'],
            ['name' => 'Larmes de Hadès', 'faction' => 'Alliance', 'serveur' => 'Hyjal'],
            ['name' => 'ComeBack', 'faction' => 'Horde', 'serveur' => 'Elune'],
            ['name' => 'YEP', 'faction' => 'Alliance', 'serveur' => 'Dalaran'],
            ['name' => 'Suspicion', 'faction' => 'Horde', 'serveur' => 'Archimonde'],
        ];

        foreach ($guilds as $data) {
            $guild = new Guild();
            $guild->setName($data['name']);
            $guild->setFaction($data['faction']);
            $guild->setServer($data['serveur']);
            $manager->persist($guild);
        }

        $manager->flush();
    }
}

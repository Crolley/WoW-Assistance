<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Classe;
use App\Entity\Guild;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ManagerRegistry $doctrine) {}

    public function load(ObjectManager $manager): void
    {
        $users = $this->doctrine->getRepository(User::class)->findAll();
        $guilds = $this->doctrine->getRepository(Guild::class)->findAll();
        $classes = $this->doctrine->getRepository(Classe::class)->findAll();

        if (empty($users) || empty($guilds) || empty($classes)) {
            throw new \RuntimeException("Users, guilds, or classes are missing. Check your fixture order.");
        }

        $names = ['Crolley', 'Eryliss', 'Mérös', 'Marfight', 'Silma', 'Faolyn', 'Arnox', 'Trapstarz', 'Azortharion', 'Crolaid', 'Arnox', 'Joof',
        'Fao', 'Kreezhem', 'Bansherz', 'Dacade', 'Freyja',  ];

        foreach ($names as $name) {
            $character = new Character();
            $character->setNameCharacter($name);

            $user = $users[array_rand($users)];
            $guild = $guilds[array_rand($guilds)];
            $classe = $classes[array_rand($classes)];
            $specs = $classe->getSpecialisations()->toArray();

            if (empty($specs)) {
                continue;
            }

            $spec = $specs[array_rand($specs)];

            $character->setUser($user);
            $character->setGuild($guild);
            $character->setClasse($classe);
            $character->setSpecialisation($spec);
            $character->setServer($guild->getServer());
            $character->setRaiderIo("https://raider.io/characters/eu/{$guild->getServer()}/" . strtolower($name));
            $character->setRole("Membre");

            $manager->persist($character);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            GuildFixtures::class,
            ClasseFixtures::class,
        ];
    }
}

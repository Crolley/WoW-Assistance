<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['email' => 'thrall@wow.com', 'password' => 'orcpass', 'pseudo' => 'Thrall'],
            ['email' => 'jaina@wow.com', 'password' => 'magepass', 'pseudo' => 'Jaina'],
            ['email' => 'sylvanas@wow.com', 'password' => 'undeadpass', 'pseudo' => 'Sylvanas'],
        ];

        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPseudo($data['pseudo']);
            $hashedPassword = $this->hasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        $manager->flush();
    }
}

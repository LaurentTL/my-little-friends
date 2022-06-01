<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $animal = new Animal();
            $animal->setNom("Animal n°$i")
                ->setType("type de l'animal")
                ->setDescription("Description de l'animal n°$i")
                ->setPhoto("https://www.kanpai.fr/sites/default/files/styles/big_header_xxs/public/uploads/2014/03/shiba-inu.jpg");
            $manager->persist($animal);
        }
        $manager->flush();
    }
}

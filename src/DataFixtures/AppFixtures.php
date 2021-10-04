<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Place;
use App\Entity\Activity;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * L'encodeur de mots de passe
     *
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Création de l'instance de Faker
        $faker = Factory::create('fr_FR');

        $format = 'Y-m-d H:i:s';

        // Génération d'un utlisateur admin
        $adminUser = new User();

        $adminHash = $this->encoder->hashPassword($adminUser, 'password');

        $adminUser->setFirstName("Dorian");
        $adminUser->setLastName("PILORGE");
        $adminUser->setEmail("dorian.pilorge@symfony.com");
        $adminUser->setPassword($adminHash);
        //$adminUser->setPicture("https://cdn.pixabay.com/photo/2012/04/26/19/43/profile-42914_960_720.png");
        //$adminUser->addUserRole($adminRole);
        $manager->persist($adminUser);

        // Génération d'utilisateurs de test
        for($u = 0; $u < 20; $u++) {
            $user = new User();

            $hash = $this->encoder->hashPassword($user, 'password');

            $user->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName())
                 ->setEmail($faker->email())
                 ->setPassword($hash)
                 ->setCreationDate($faker->dateTimeBetween('-6 months'));

            $manager->persist($user);

            // Génération de lieux pour un utilisateur
            for ($p = 0; $p < random_int(0,2); $p++) {
                $place = new Place();
                $place->setTitle($faker->company())
                      ->setDescription($faker->realText())
                      ->setPicture($faker->imageUrl())
                      ->setCreationDate($faker->dateTimeBetween('-6 months'))
                      ->setUser($user);

                $manager->persist($place);
            }

            // Génération d'activités pour un utilisateur
            for ($a = 0; $a < random_int(0,2); $a++) {
                $activity = new Activity();
                $activity->setTitle($faker->company())
                         ->setDescription($faker->realText())
                         ->setPicture($faker->imageUrl())
                         ->setCreationDate($faker->dateTimeBetween('-6 months'))
                         ->setUser($user);

                $manager->persist($activity);
            }
        }

        $manager->flush();
    }
}

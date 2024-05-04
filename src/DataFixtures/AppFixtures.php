<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        for ($j=1;$j<=3;$j++){
        $libelle=$faker->name;
        $cat=new Categories();
          $cat->setLibelle($libelle)
          ->setSlug(strtolower(preg_replace('/[^a-zA-Z0-9-]/','-',$libelle)))
          ->setDescription($faker->sentence);
        $manager->persist($cat);
        for ($i=1; $i <random_int(10,15) ; $i++) { 
            $livre = new Livre();
            $titre=$faker->name();
            $datetime=$faker->dateTime();
            $datetimeimmutable=\DateTimeImmutable::createFromMutable($datetime);
            $livre->setImage("https://picsum.photos/200")     
            ->setTitre($titre)
            ->setEditeur($faker->company())
            ->setISBN($faker->isbn13())
            ->setPrix($faker->numberBetween(10,300))
            ->setEditedAt($datetimeimmutable)
            ->setSlug(strtolower(preg_replace('/[^a-zA-Z0-9-]/','-',$titre)))
            ->setResume($faker->sentence(20))
            ->setAuteur($faker->userName())
            ->setQte($faker->numberBetween(0,300))
            ->setCategorie($cat);
            $manager->persist($livre);
        }
    }
    $manager->flush();
    }
}

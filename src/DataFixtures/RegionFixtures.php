<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegionFixtures extends Fixture
{


    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        foreach (FixturesData::DATA as $key => $value)
        {
            $region = new Region();
            $region->setName($key);
            $region->setSlug(
                $this->slugger->slug($key)
            );
            $this->addReference($key, $region);

            $manager->persist($region);
        }

        $manager->flush();

      /* $country = new Country();
       $country->setName('france');
       $country->setDescription('pays des lumières');
       $country->setPoster('ici drapeau');
       $country->setSlug($this->slugger->slug('pays des lumières'));

        $country1 = new Country();
        $country1->setName('sénégal');
        $country1->setDescription('pays de la téranga');
        $country1->setPoster('ici drapeau');
        $country1->setSlug($this->slugger->slug('pays de la téranga'));

        $country2 = new Country();
        $country2->setName('japon');
        $country2->setDescription('pays du soleil levant');
        $country2->setPoster('ici drapeau');
        $country2->setSlug($this->slugger->slug('pays du soleil levant'));

        $manager->persist($country);
        $manager->persist($country1);
        $manager->persist($country2);*/


    }
}

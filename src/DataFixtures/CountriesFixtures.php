<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CountriesFixtures extends Fixture implements OrderedFixtureInterface
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

        foreach (FixturesData::DATA as $region => $countries)
        {
            foreach ($countries as $country)
            {
                $entity = new Country();
                $entity->setName($country['name']);
                $entity->setDescription($country['description']);
                $entity->setPoster($country['poster']);
                $entity->setSlug( $this->slugger->slug($country['name']));


                $entity->setRegion( $this->getReference($region) );

                $manager->persist($entity);
            }
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return [
          RegionFixtures::class
        ];
    }
}

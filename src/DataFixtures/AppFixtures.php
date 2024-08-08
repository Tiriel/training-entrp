<?php

namespace App\DataFixtures;

use App\Factory\TaskFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Clock\ClockAwareTrait;

class AppFixtures extends Fixture implements OrderedFixtureInterface
{
    use ClockAwareTrait;

    public function load(ObjectManager $manager): void
    {
        TaskFactory::createMany(10);
    }

    public function getOrder()
    {
        return 2;
    }
}

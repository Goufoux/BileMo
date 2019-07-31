<?php

namespace App\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    const NB_CUSTOMER = 10;
    const NB_USER = 20;
    const NB_PRODUCT = 100;

    private $manager;
    private $faker;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        $this->createCustomer($manager);
        $this->createProduct($manager);
        $this->createUser($manager);

        $manager->flush();
    }

    public function createCustomer(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_CUSTOMER; $i++) {
            $customer = new Customer();
            $customer->setCreatedAt($this->faker->dateTimeBetween());
            $customer->setCompany($this->faker->company);
            $customer->setToken($this->faker->sha256);
            $this->addReference('Customer_'.$i, $customer);
            $manager->persist($customer);
        }
    }

    public function createUser(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_USER; $i++) {
            $user = new User();
            $user->setCreatedAt($this->faker->dateTimeBetween());
            $user->setFirstName($this->faker->firstName);
            $user->setName($this->faker->name);
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            $user->setCustomer($this->getReference('Customer_'.rand(1, self::NB_CUSTOMER)));
            $manager->persist($user);
        }
    }

    public function createProduct(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_PRODUCT; $i++) {
            $product = new Product();
            $product->setCreatedAt($this->faker->dateTimeBetween());
            $product->setName($this->faker->userName);
            $product->setPrice($this->faker->randomFloat(2, 50, 2000));
            $product->setDescription($this->faker->sentence(550));
            $product->setCustomer($this->getReference('Customer_'.rand(1, self::NB_CUSTOMER)));
            $manager->persist($product);
        }
    }
}
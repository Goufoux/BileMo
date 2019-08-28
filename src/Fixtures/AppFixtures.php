<?php

namespace App\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    const NB_CUSTOMER = 10;
    const NB_USER = 20;
    const NB_PRODUCT = 100;
    const PASSWORD = 'password';

    private $faker;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr_FR');
        $this->passwordEncoder = $passwordEncoder;
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
            $customer->setEmail($this->faker->email);
            $customer->setPassword($this->passwordEncoder->encodePassword(
                $customer,
                self::PASSWORD
            ));
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
            $product->setMark($this->faker->company);
            $product->setScreenDetails($this->faker->sentence());
            $product->setCameraDetails($this->faker->sentence());
            $product->setChip($this->faker->sentence());
            $product->setDescription($this->faker->sentence(550));
            $product->setCustomer($this->getReference('Customer_'.rand(1, self::NB_CUSTOMER)));
            $manager->persist($product);
        }
    }
}
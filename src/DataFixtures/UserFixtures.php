<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const REF_TEST_USER = 'user_test';

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setNickname('Test User')
            ->setUsername('test')
            ->setPlainPassword('password');
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REF_TEST_USER, $user);
    }
}

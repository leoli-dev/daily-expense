<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const DEFAULT = 'user-default';

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
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $defaultUser = new User();
        $defaultUser
            ->setNickname('Default user')
            ->setUsername('default')
            ->setPlainPassword('password');
        $defaultUser->setPassword(
            $this->passwordEncoder->encodePassword(
                $defaultUser,
                $defaultUser->getPlainPassword()
            )
        );
        $manager->persist($defaultUser);
        $manager->flush();
        $this->addReference(self::DEFAULT, $defaultUser);
    }
}

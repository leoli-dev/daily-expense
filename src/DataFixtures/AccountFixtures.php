<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public const CASH_CAD = 'account-cash-cad';
    public const CASH_USD = 'account-cash-usd';
    public const CASH_EUR = 'account-cash-eur';
    public const CASH_HKD = 'account-cash-hkd';
    public const CASH_CNY = 'account-cash-cny';

    public function load(ObjectManager $manager)
    {
        $cadCash = new Account();
        $cadCash
            ->setName('CAD cash')
            ->setCurrency($this->getReference(CurrencyFixtures::CAD))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setCreatedBy($this->getReference(UserFixtures::DEFAULT));

        $manager->persist($cadCash);
        $manager->flush();
        $this->setReference(self::CASH_CAD, $cadCash);
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            CurrencyFixtures::class,
            UserFixtures::class,
        ];
    }
}

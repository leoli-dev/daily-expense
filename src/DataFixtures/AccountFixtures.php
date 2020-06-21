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
            ->setCreatedAt(new \DateTimeImmutable());

        $usdCash = new Account();
        $usdCash
            ->setName('USD cash')
            ->setCurrency($this->getReference(CurrencyFixtures::USD))
            ->setCreatedAt(new \DateTimeImmutable());

        $eurCash = new Account();
        $eurCash
            ->setName('EUR cash')
            ->setCurrency($this->getReference(CurrencyFixtures::EUR))
            ->setCreatedAt(new \DateTimeImmutable());

        $hkdCash = new Account();
        $hkdCash
            ->setName('HKD cash')
            ->setCurrency($this->getReference(CurrencyFixtures::HKD))
            ->setCreatedAt(new \DateTimeImmutable());

        $cnyCash = new Account();
        $cnyCash
            ->setName('CNY cash')
            ->setCurrency($this->getReference(CurrencyFixtures::CNY))
            ->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($cadCash);
        $manager->persist($usdCash);
        $manager->persist($eurCash);
        $manager->persist($hkdCash);
        $manager->persist($cnyCash);
        $manager->flush();
        $this->setReference(self::CASH_CAD, $cadCash);
        $this->setReference(self::CASH_USD, $usdCash);
        $this->setReference(self::CASH_EUR, $eurCash);
        $this->setReference(self::CASH_HKD, $hkdCash);
        $this->setReference(self::CASH_CNY, $cnyCash);
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

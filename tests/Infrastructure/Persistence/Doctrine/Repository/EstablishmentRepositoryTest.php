<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Establishment\Entity\Restaurant as RestaurantDomain;
use Domain\Establishment\ValueObject\EstablishmentType;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\Phone;
use Infrastructure\Persistence\Doctrine\Entity\Establishment;
use Infrastructure\Persistence\Doctrine\Repository\EstablishmentRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EstablishmentRepositoryTest extends KernelTestCase
{
    private EstablishmentRepository $sut;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = self::getContainer()->get('doctrine.orm.default_entity_manager');
        $this->sut = $this->entityManager->getRepository(Establishment::class);
    }

    public function testSave(): void
    {
        // Given
        $establishment = new RestaurantDomain(
            uuid: EstablishmentIdentifier::fromString('13647023-b538-4296-bae5-263a1b221d62'),
            name: 'Burger King',
            address: new Address(
                address: '2 Av. Charles Mignet',
                city: 'Paris',
                zipCode: '75015',
                country: 'France'
            ),
            phone: Phone::fromString('+33100224389'),
            siret: '44649371500091'
        );

        // When
        $this->sut->save($establishment);
        $this->entityManager->flush();

        // Then
        $persistedEstablishment = self::getContainer()->get('doctrine.dbal.default_connection')
            ->fetchAssociative(
                <<<'SQL'
                    SELECT * FROM establishments WHERE siret = '44649371500091'
                SQL
            );

        self::assertEquals('13647023-b538-4296-bae5-263a1b221d62', $persistedEstablishment['id']);
        self::assertEquals('Burger King', $persistedEstablishment['name']);
        self::assertEquals('2 Av. Charles Mignet', $persistedEstablishment['address']);
        self::assertEquals('75015', $persistedEstablishment['zipcode']);
        self::assertEquals('France', $persistedEstablishment['country']);
        self::assertEquals('Paris', $persistedEstablishment['city']);
        self::assertEquals('+33100224389', $persistedEstablishment['phone']);
        self::assertEquals('44649371500091', $persistedEstablishment['siret']);
    }

    public function testFindById(): void
    {
        // Given
        self::getContainer()->get('doctrine.dbal.default_connection')
            ->insert(
                'establishments',
                [
                    'id' => '13647023-b538-4296-bae5-263a1b221d62',
                    'name' => 'Burger King',
                    'type' => EstablishmentType::Restaurant->value,
                    'address' => '2 Av. Charles Mignet',
                    'city' => 'Paris',
                    'zipCode' => '75015',
                    'country' => 'France',
                    'phone' => '+33100224389',
                    'siret' => '44649371500091',
                ]
            );

        // When
        $id = EstablishmentIdentifier::fromString('13647023-b538-4296-bae5-263a1b221d62');
        $actualEstablishment = $this->sut->findById($id);

        // Then
        self::assertEquals($id, $actualEstablishment->getId());
        self::assertInstanceOf(RestaurantDomain::class, $actualEstablishment);
    }

    public function testFindBySiret(): void
    {
        // Given
        self::getContainer()->get('doctrine.dbal.default_connection')
            ->insert(
                'establishments',
                [
                    'id' => '13647023-b538-4296-bae5-263a1b221d62',
                    'name' => 'Burger King',
                    'type' => EstablishmentType::Restaurant->value,
                    'address' => '2 Av. Charles Mignet',
                    'city' => 'Paris',
                    'zipCode' => '75015',
                    'country' => 'France',
                    'phone' => '+33100224389',
                    'siret' => '44649371500091',
                ]
            );

        // When
        $siret = '44649371500091';
        $actualEstablishment = $this->sut->findBySiret($siret);

        // Then
        self::assertEquals($siret, $actualEstablishment->getSiret());
        self::assertInstanceOf(RestaurantDomain::class, $actualEstablishment);
    }
}

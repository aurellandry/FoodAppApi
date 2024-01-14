<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Fixture;

use Domain\Shared\ValueObject\Email;
use Domain\Shared\ValueObject\EstablishmentIdentifier;
use Domain\Establishment\ValueObject\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\Establishment\Entity\Restaurant;
use Domain\Establishment\Service\EstablishmentPersistenceCommand;
use Domain\Shared\ValueObject\Address;
use Domain\Shared\ValueObject\Phone;

final class EstablishmentFixtures extends Fixture
{
    public function __construct(
        private readonly EstablishmentPersistenceCommand $persistence
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $establishment = new Restaurant(
            uuid: EstablishmentIdentifier::fromString(
                '153f5841-3d5e-46fa-9364-a901944cbf17'
            ),
            name: 'Bubbles CMR',
            address: new Address(
                address: 'Warda, Bois st anastasie. Face Immeuble Hajal.',
                city: 'Yaoundé',
                country: 'Cameroun'
            ),
            phone: Phone::fromString('+2376700226781'),
            siret: '55322487900324',
        );

        $this->persistence->save($establishment);
        $manager->flush();
    }
}

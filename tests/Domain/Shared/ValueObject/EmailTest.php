<?php

declare(strict_types=1);

namespace Tests\Domain\Shared\ValueObject;

use Domain\Shared\ValueObject\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testEmailIsInvalid()
    {
        $emailString = 'invalidEmail';

        $this->expectException(InvalidArgumentException::class);

        Email::fromString($emailString);
    }

    public function testEmailIsValid()
    {
        $emailString = 'toto@test.com';

        $email = Email::fromString($emailString);

        $this->assertEquals($email::class, Email::class);
        $this->assertEquals('toto@test.com', (string) $email);
    }
}

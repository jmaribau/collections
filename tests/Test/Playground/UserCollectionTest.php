<?php

namespace Test\Playground;

use Fi\Collections\Collection;
use Fi\Playground\User;
use Fi\Playground\RealName;
use Fi\Playground\Email;
use Fi\Playground\Password;
use PHPUnit\Framework\TestCase;

class UserCollectionTest extends TestCase
{

    public function testItCanCreateUserCollection(): void
    {
        $sut = $this->createACollection();
        $this->assertEquals(5, $sut->count());
        $this->assertEquals(User::class, $sut->getType());
    }

    public function testItCanGetAUserByEmail(): void
    {
        $sut = $this->createACollection();
        $getByEmail = function (User $user) {
            return $user->getEmail() === 'koko.tero@example.com';
        };
        $user = $sut->getBy($getByEmail);
        $expected = $this->getuser('Koko', 'Tero', 'koko.tero@example.com', 'password');
        $this->assertEquals($expected, $user);
    }

    public function testItCanFilterCollection(): void
    {
        $sut = $this->createACollection();
        $filterByEmailDomain = function (User $user) {
            return $user->getEmailDomain() === 'mac.com';
        };
        $filtered = $sut->filter($filterByEmailDomain);
        $expected = Collection::collect([$this->getuser('Fran', 'Iglesias', 'franiglesias@mac.com', 'password')]);
        $this->assertEquals($expected, $filtered);
    }

    private function getuser(string $firstname, string $lastname, string $email, string $password): User
    {
        return new User(
            new RealName($firstname, $lastname),
            new Email($email),
            new Password($password)
        );
    }

    private function createACollection(): Collection
    {
        $users = [
            $this->getuser('Fran', 'Iglesias', 'franiglesias@mac.com', 'password'),
            $this->getuser('Pedro', 'Pérez', 'pedro.perez@example.com', 'password'),
            $this->getuser('Elena', 'Fernández', 'elena.fernandez@example.com', 'password'),
            $this->getuser('Marta', 'González', 'marta.gonzalez@example.com', 'password'),
            $this->getuser('Koko', 'Tero', 'koko.tero@example.com', 'password'),
        ];

        return Collection::collect($users);
    }
}

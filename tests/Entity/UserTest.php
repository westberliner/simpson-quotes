<?php

namespace App\Tests\Entity;

use App\Entity\Quotation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;

class UserTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testUserModel(): void
    {
        $username = 'test.username';
        $firstname = 'firstname';
        $surname = 'surname';
        $address = 'some address';
        $quote = 'some quote';

        $user = new User();
        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setSurname($surname);
        $user->setAddress($address);
        $quotation = new Quotation($quote);
        $user->addQuotation($quotation);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $result = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['username' => $username], ['id' => 'DESC'])
        ;

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($firstname, $result->getFirstname());
        $this->assertSame($surname, $result->getSurname());
        $this->assertSame($address, $result->getAddress());
        $this->assertSame($quote, $result->getQuotations()->first()->getQuotation());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

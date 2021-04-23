<?php

namespace App\Tests\Api;

use App\Entity\Quotation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \App\Entity\User
     */
    private $user;

    /**
     * @var \App\Entity\Quotation
     */
    private $quotation;

    protected function setUp(): void
    {
        $this->client =  static::createClient();

        $username = 'test.username';
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $user = new User();
        $user->setUsername($username);
        $user->setFirstname('firstname');
        $user->setSurname('surname');
        $user->setAddress('address');
        $this->quotation = new Quotation('quote');
        $user->addQuotation($this->quotation);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['username' => $username])
        ;
    }

    public function testUser(): void
    {
        $this->client->request('GET', '/api/user');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString($this->user->getUsername(), $this->client->getResponse()->getContent());

        $this->client->request('GET', '/api/user/' . $this->user->getId() . '/quotation');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString($this->quotation->getQuotation(), $this->client->getResponse()->getContent());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

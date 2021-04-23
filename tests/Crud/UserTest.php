<?php

namespace App\Tests\Crud;

use App\Entity\Quotation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client =  static::createClient();
        $this->client->followRedirects();
    }

    public function testCrudUser(): void
    {
        // login
        $crawler = $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Sign in')->form();
        $form['_username'] = 'burns';
        $form['_password'] = 'smithers';
        $this->client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Simpson Quotes',
            $this->client->getResponse()->getContent()
        );

        // create
        // edit
        // view
        // Delete

        // Logout
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Login',
            $this->client->getResponse()->getContent()
        );
    }
}

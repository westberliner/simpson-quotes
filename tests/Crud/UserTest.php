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
        $uri = $this->client->getCrawler()->selectLink('Add User')->link()->getUri();
        $crawler = $this->client->request('GET', $uri);
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Create User',
            $this->client->getResponse()->getContent()
        );

        $form = $crawler->selectButton('Create')->form();
        $form['User[username]'] = 'Create Test';
        $form['User[firstname]'] = 'Create firstname';
        $form['User[surname]'] = 'Create lastname';
        $form['User[address]'] = 'Create address';
        // Works only with js.
        // $form['User[quotations][0]'] = 'Create quote';
        $this->client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Create Test',
            $this->client->getResponse()->getContent()
        );

        // edit
        $uri = $this->client->getCrawler()->selectLink('Edit')->link()->getUri();
        $crawler = $this->client->request('GET', $uri);
        $form = $crawler->selectButton('Save changes')->form();
        $form['User[username]'] = 'Edit Test';
        $this->client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Edit Test',
            $this->client->getResponse()->getContent()
        );

        // view
        $uri = $this->client->getCrawler()->selectLink('Show')->link()->getUri();
        $this->client->request('GET', $uri);
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'User Details',
            $this->client->getResponse()->getContent()
        );

        // Delete
        // Works only with js.

        // Logout
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString(
            'Login',
            $this->client->getResponse()->getContent()
        );
    }
}

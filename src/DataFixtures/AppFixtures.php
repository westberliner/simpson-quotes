<?php

namespace App\DataFixtures;

use App\Entity\Quotation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $objectManager)
    {
        foreach ($this->getUsers() as $data) {
            $user = new User();

            $user->setUsername($data['username']);
            $user->setFirstname($data['firstname']);
            $user->setSurname($data['surname']);
            $user->setAddress($data['address']);

            $objectManager->persist($user);

            if (!empty($data['quotation'])) {
                foreach ($data['quotation'] as $text) {
                    $quotation = new Quotation($text);
                    $user->addQuotation($quotation);
                }
                $objectManager->persist($user);
            }
        }

        $objectManager->flush();
    }

    private function getUsers(): array
    {
        return [
            [
                'username' => 'edna.krabappel',
                'firstname' => 'Edna',
                'surname' => 'Krabappel',
                'address' => '82 Evergreen Terrace Springfield'
            ],
            [
                'username' => 'homer.simpson',
                'firstname' => 'Homer',
                'surname' => 'Simpson',
                'address' => '742 Evergreen Terrace Springfield',
                'quotation' => ['D’oh!']
            ],
            [
                'username' => 'marge.simpson',
                'firstname' => 'Marge',
                'surname' => 'Simpson',
                'address' => '742 Evergreen Terrace Springfield',
                'quotation' => [
                    'Go out on a Tuesday? Who am I, Charlie Sheen?',
                    'I don’t mind if you pee in the shower, but only if you’re taking a shower.'
                ]
            ],
            [
                'username' => 'barney.gumble',
                'firstname' => 'Barney',
                'surname' => 'Gumble',
                'address' => 'Moes Taverne Springfield',
                'quotation' => ['We want chilly-willy! We want chilly-willy!']
            ],
            [
                'username' => 'apu.nahasapeemapetilon',
                'firstname' => 'Apu',
                'surname' => 'Nahasapeemapetilon',
                'address' => 'Kwik-E-Mart Springfield'
            ]
        ];
    }
}

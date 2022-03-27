<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function createClient(array $data)
    {
        $client = new Client();
        $client->setLastName($data['lastname']);
        $client->setFirstName($data['firstname']);

        // password hash
        $password = $this->userPasswordHasher->hashPassword($client, $data['password']);
        $client->setPassword($password);
        $client->setUsername($data['username']);

        $client->setCreated(new \DateTime());

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}

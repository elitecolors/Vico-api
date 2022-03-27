<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientValidator
{
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function validateClient(array $data)
    {
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'lastname' => new Assert\Length(['min' => 1]),
            'firstname' => new Assert\Length(['min' => 1]),
            'password' => new Assert\Length(['min' => 5]),
            'username' => new Assert\Email(),
        ]);

        $validator = $this->validator->validate($data, $constraint);

        $repoCLient = $this->entityManager->getRepository(Client::class);

        $findCLient = $repoCLient->findOneBy(['username' => $data['username']]);

        if ($findCLient) {
            $validator->add(new ConstraintViolation('Client username already exist', null, [], null, null, null));
        }

        return $validator;
    }
}

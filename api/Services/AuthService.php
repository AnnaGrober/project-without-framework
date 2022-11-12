<?php

namespace Api\Services;

use Common\Entities\User;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

/**
 *
 */
class AuthService
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function register(array $data): array
    {
        try {
            $user = new User();
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);

            $this->em->persist($user);
            $this->em->flush();
            $user = (array)$user;

            return ['success' => true, 'user' => $user];
        } catch (\Exception $e) {
            throw $e;
        }
    }

}

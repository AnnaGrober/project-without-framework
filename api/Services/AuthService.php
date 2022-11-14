<?php

namespace Api\Services;

use Common\Entities\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Carbon\Carbon;
use Firebase\JWT\JWT;

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
     * @param array $data
     *
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
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

    /**
     * @param array $data
     *
     * @return array
     * @throws \Exception
     */
    public function login(array $data): array
    {
        try {
            $user = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
            if (!password_verify($data['password'], $user->getPassword())) {
                return ['success' => false, 'message' => 'Неверный пароль!'];
            }
            $jwt = $this->generateToken($user);

            return ['success' => true, 'message' => 'Успешный вход в систему!', 'jwt' => $jwt];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateToken(User $user): string
    {
        $key     = getenv('JWT_SECRET_KEY');
        $payload = [
            'iss'  => getenv('APP_URL'),
            'aud'  => getenv('APP_URL'),
            'iat'  => Carbon::now()->timestamp,
            'nbf'  => Carbon::now()->timestamp,
            'data' => [
                'id'    => $user->getId(),
                'name'  => $user->getName(),
                'email' => $user->getEmail(),
            ],
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

}

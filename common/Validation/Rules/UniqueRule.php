<?php

namespace Common\Validation\Rules;

use Common\Entities\User;
use Rakit\Validation\Rule;

/**
 *
 */
class UniqueRule extends Rule
{
    protected $message = ':attribute :value уже используется';

    protected $fillableParams = ['table', 'column'];

    protected \Doctrine\ORM\EntityManager $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Rakit\Validation\MissingRequiredParameterException
     */
    public function check($value): bool
    {
        $count = $this->em->getRepository(User::class)->count(['email' => $value]);

        return $count === 0;
    }
}

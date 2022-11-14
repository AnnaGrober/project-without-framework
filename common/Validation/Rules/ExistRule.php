<?php

namespace Common\Validation\Rules;

use Common\Entities\User;

/**
 *
 */
class ExistRule extends \Rakit\Validation\Rule
{

    protected $message = ':attribute :value не зарегистрирован';

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

        return $count !== 0;
    }
}
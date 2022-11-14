<?php

namespace Common\Validation;

use Common\Validation\Rules\ExistRule;
use Common\Validation\Rules\UniqueRule;
use DI\Container;
use Rakit\Validation\RuleQuashException;

/**
 *
 */
class Validator extends \Rakit\Validation\Validator
{
    protected array $rules = [
        'unique' => UniqueRule::class,
        'exist'  => ExistRule::class,
    ];
    protected Container $container;

    /**
     * @param Container $container
     * @param array     $messages
     *
     * @throws RuleQuashException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $container, array $messages = [])
    {
        parent::__construct($messages);
        $this->container = $container;
        foreach ($this->rules as $ruleName => $validator) {
            $this->addValidator($ruleName, $this->container->get($validator));
        }
    }

}
<?php

namespace Api\Controllers;

use Api\Services\AuthService;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Exceptions\Data\ValidationException;
use Rakit\Validation\RuleNotFoundException;
use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;
use \Common\Response;

class AuthController extends Controller
{
    private $service;
    private $container;

    public function __construct(AuthService $service, Container $container)
    {
        $this->service   = $service;
        $this->container = $container;
    }

    /**
     * @throws \JsonException
     * @throws RuleNotFoundException
     * @throws RuleQuashException
     */
    public function register(Request $request)
    {
        $validator = new Validator();
        $validator->addValidator('unique', $this->container->get('Common\Validation\Rules\UniqueRule'));

        $data       = $request->request->all();
        $validation = $validator->make($data, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException(json_encode($errors->all(), JSON_THROW_ON_ERROR), 422);
        }

        return new Response($this->service->register($data));
    }

}

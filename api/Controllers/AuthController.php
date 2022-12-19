<?php

namespace Api\Controllers;

use Api\Services\AuthService;
use Exceptions\Data\ValidationException;
use Rakit\Validation\RuleQuashException;
use Symfony\Component\HttpFoundation\Request;
use \Common\Response;
use Common\Validation\Validator;

class AuthController extends Controller
{
    private AuthService $service;
    private Validator $validator;

    public function __construct(AuthService $service, Validator $validator)
    {
        $this->service   = $service;
        $this->validator = $validator;
    }

    public function register(Request $request)
    {
        $data       = $request->request->all();
        $validation = $this->validator->make($data, [
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


    /**
     * @param Request $request
     *
     * @return void
     * @throws \JsonException
     */
    public function login(Request $request)
    {
        $data       = $request->request->all();
        $validation = $this->validator->make($data, [
            'email'    => 'required|email|exist:users,email',
            'password' => 'required|min:6',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errors = $validation->errors();
            throw new ValidationException(json_encode($errors->all(), JSON_THROW_ON_ERROR), 422);
        }

        return new Response($this->service->login($data));
    }

}

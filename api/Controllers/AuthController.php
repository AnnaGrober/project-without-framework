<?php

namespace Api\Controllers;

use Api\Services\AuthService;
use Exceptions\Data\ValidationException;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    private $service;

    public function __construct(AuthService $service) {

    }

    /**
     * @throws \JsonException
     */
    public function register(Request $request)
    {
        $validator  = new Validator();
        $data       = $request->request->all();
        $validation = $validator->make($data, [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        // then validate
        $validation->validate();

        if ($validation->fails()) {
            $errors    = $validation->errors();
            throw new ValidationException(json_encode($errors->all(), JSON_THROW_ON_ERROR), 422);
        }
    }

}

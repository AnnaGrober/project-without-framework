<?php

namespace Api\Controllers;

use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = new Validator();
        $data = $request->request->all();
        $validation = $validator->make($data, [
            'name'                  => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
        ]);
        // then validate
        $validation->validate();

        if ($validation->fails()) {

        }


    }

}
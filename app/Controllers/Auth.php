<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function login()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->respond([
                'message' => 'Invalid JSON'
            ], 400);
        }

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->respond([
                'message' => 'Email & password required'
            ], 400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->respond([
                'message' => 'User not found'
            ], 401);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->respond([
                'message' => 'Invalid password'
            ], 401);
        }

        return $this->respond([
              'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email']
            ]
        ], 200);
    }
}

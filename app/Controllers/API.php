<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class API extends BaseController
{
    use ResponseTrait;

    private $dataPath;

    public function __construct()
    {
        $this->dataPath = APPPATH . 'Data/';
    }

    // Obtener todos los furanchos
    public function getFuranchos()
    {
        $json = file_get_contents($this->dataPath . 'furanchos.json');
        $data = json_decode($json, true);
        return $this->response->setJSON($data);
    }

    // Obtener un furancho por ID
    public function getFurancho($id)
    {
        $json = file_get_contents($this->dataPath . 'furanchos.json');
        $data = json_decode($json, true);
        
        foreach ($data as $furancho) {
            if ($furancho['id'] == $id) {
                return $this->response->setJSON($furancho);
            }
        }
        
        return $this->failNotFound('Furancho no encontrado');
    }

    // Obtener usuarios
    public function getUsers()
    {
        $json = file_get_contents($this->dataPath . 'users.json');
        $data = json_decode($json, true);
        // No enviar contraseñas
        foreach ($data as &$user) {
            unset($user['password']);
        }
        return $this->response->setJSON($data);
    }

    // Obtener usuario por ID
    public function getUser($id)
    {
        $json = file_get_contents($this->dataPath . 'users.json');
        $data = json_decode($json, true);
        
        foreach ($data as $user) {
            if ($user['id'] == $id) {
                unset($user['password']);
                return $this->response->setJSON($user);
            }
        }
        
        return $this->failNotFound('Usuario no encontrado');
    }

    // Login (demostración simple)
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        if (!$username || !$password) {
            return $this->failValidationError('Username y password requeridos');
        }

        $json = file_get_contents($this->dataPath . 'users.json');
        $users = json_decode($json, true);
        
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                // En un prototipo, comparación simple
                if ($password === 'demo123') {
                    unset($user['password']);
                    return $this->response->setJSON([
                        'success' => true,
                        'user' => $user,
                        'token' => 'demo_token_' . $user['id']
                    ]);
                }
            }
        }
        
        return $this->failUnauthorized('Credenciales inválidas');
    }
}

<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RolCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user_rol = $session->get('rol');

        $rolMap = [
            'admin' => 1,
            'user' => 2
        ];
        //verificar si el usuario tiene los roles adecuados
        if ($arguments) {
            $result = array_map(fn($role) => $rolMap[$role], $arguments);
            if (!in_array($user_rol, $result)) {
                return redirect()->to('/admin')->with('respuesta', [
                    'type' => 'danger',
                    'msg' => 'NO TIENES PERMISOS'
                ]);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
<?php

    require_once __DIR__ . '/../model/Usuario.php';

    class LoginController{
        private $usuarioModel;

        public function __construct()
        {
            $this->usuarioModel = new Usuario();
        }

        public function login($usuario, $clave){
            $user = $this->usuarioModel->validarLogin($usuario, $clave);

        header("Content-Type: application/json");

        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['usuario'];

            echo json_encode([
                "success" => true,
                "usuario" => $user['usuario'],
                "rol"     => $user['idRol']
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Usuario o contraseña incorrectos"
            ]);
        }
    }
    }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $clave   = $_POST['clave'] ?? '';

            $controller = new LoginController();
            $controller->login($usuario, $clave);
        }

?>
<?php
require_once __DIR__ . '/../model/Contrato.php';

class ContratoController
{
    private $contratoModel;

    public function __construct()
    {
        $this->contratoModel = new Contrato();
    }

    public function registrarContrato()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos no válidos"]);
            return;
        }

        $resultado = $this->contratoModel->registrarContrato($data);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function actualizarContrato()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["idContrato"])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Faltan datos"]);
            return;
        }

        $resultado = $this->contratoModel->actualizarContrato($data);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function listarContratos()
    {
        $resultado = $this->contratoModel->listarContratos();

        header("Content-Type: application/json");
        if (isset($resultado['error'])) {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "error"   => $resultado['error']
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "data"    => $resultado
            ]);
        }
    }

    public function obtenerContratosPorEmpleado()
    {
        $idEmpleado = $_GET['idEmpleado'] ?? 0;
        $resultado = $this->contratoModel->obtenerContratosPorEmpleado($idEmpleado);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function cambiarEstadoContrato()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["idContrato"], $data["idEstadoContrato"])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $resultado = $this->contratoModel->cambiarEstadoContrato(
            $data["idContrato"],
            $data["idEstadoContrato"]
        );

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function obtenerTiposContrato()
    {
        $resultado = $this->contratoModel->obtenerTiposContrato();
        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function obtenerEstadosContrato()
    {
        $resultado = $this->contratoModel->obtenerEstadosContrato();
        header("Content-Type: application/json");
        echo json_encode($resultado);
    }
}

$controller = new ContratoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'listarContratos') {
        $controller->listarContratos();
    } elseif ($action === 'contratosPorEmpleado') {
        $controller->obtenerContratosPorEmpleado();
    } elseif ($action === 'obtenerTiposContrato') {
        $controller->obtenerTiposContrato();
    } elseif ($action === 'obtenerEstadosContrato') {
        $controller->obtenerEstadosContrato();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    if ($action === 'registrarContrato') {
        $controller->registrarContrato();
    } elseif ($action === 'actualizarContrato') {
        $controller->actualizarContrato();
    } elseif ($action === 'cambiarEstado') {
        $controller->cambiarEstadoContrato();
    }
}

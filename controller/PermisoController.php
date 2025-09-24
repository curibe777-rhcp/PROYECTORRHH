<?php
require_once __DIR__ . '/../models/Permisos.php';

class PermisoController {
    private $permisoModel;

    public function __construct() {
        $this->permisoModel = new Permiso();
    }

    // ✅ Listar permisos
    public function listar() {
        $permisos = $this->permisoModel->listarPermisos();
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "data" => $permisos]);
    }

    // ✅ Obtener tipos de permiso
    public function obtenerTipos() {
        $tipos = $this->permisoModel->obtenerTiposPermiso();
        header("Content-Type: application/json");
        echo json_encode($tipos);
    }

    // ✅ Obtener estados de permiso
    public function obtenerEstados() {
        $estados = $this->permisoModel->obtenerEstadosPermiso();
        header("Content-Type: application/json");
        echo json_encode($estados);
    }

    // ✅ Registrar permiso
    public function registrar() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos no válidos"]);
            return;
        }

        $resultado = $this->permisoModel->registrarPermiso($data);
        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    // ✅ Actualizar estado (Aprobar/Rechazar)
    public function actualizarEstado() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["idPermiso"], $data["idEstadoPermiso"], $data["usuario_mod"])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $resultado = $this->permisoModel->actualizarEstado(
            $data["idPermiso"],
            $data["idEstadoPermiso"],
            $data["usuario_mod"]
        );

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }
}

// ✅ Enrutador simple
$action = $_GET['action'] ?? '';
$controller = new PermisoController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'listar') {
        $controller->listar();
    } elseif ($action === 'tipos') {
        $controller->obtenerTipos();
    } elseif ($action === 'estados') {
        $controller->obtenerEstados();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'registrar') {
        $controller->registrar();
    } elseif ($action === 'actualizarEstado') {
        $controller->actualizarEstado();
    }
}


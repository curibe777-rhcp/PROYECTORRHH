<?php
require_once __DIR__ . '/../model/Permisos.php';

class PermisoController {
    private $permisoModel;

    public function __construct() {
        $this->permisoModel = new Permiso();
    }

    public function handleRequest($action) {
        switch ($action) {
            case "listarPermisos":
                $this->listarPermisos();
                break;
            case "registrarPermiso":
                $this->registrarPermiso();
                break;
            case "obtenerPermiso":
                $this->obtenerPermiso();
                break;
            case "actualizarPermiso":
                $this->actualizarPermiso();
                break;
            case "eliminarPermiso":
                $this->eliminarPermiso();
                break;
            case "tiposPermiso":
                $this->tiposPermiso();
                break;
            case "listarEmpleados":
                $this->listarEmpleados();
                break;
            default:
                $this->response(["success" => false, "error" => "Acción no válida"]);
        }
    }

    private function listarPermisos() {
        $data = $this->permisoModel->listarPermisos();
        $this->response($data);
    }

    private function registrarPermiso() {
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            $this->response(["success" => false, "error" => "Datos inválidos"]);
            return;
        }

        $ok = $this->permisoModel->registrarPermiso(
            $input["idEmpleado"],
            $input["idTipoPermiso"],
            $input["fechaInicio"],
            $input["fechaFin"],
            $input["estado"],
            $input["motivo"]
        );

        $this->response(["success" => $ok]);
    }

    private function obtenerPermiso() {
        $idPermiso = $_GET["idPermiso"] ?? null;

        if (!$idPermiso) {
            $this->response(["success" => false, "error" => "ID no proporcionado"]);
            return;
        }

        $permiso = $this->permisoModel->obtenerPermiso($idPermiso);

        if (!$permiso) {
            $this->response(["success" => false, "error" => "No encontrado"]);
            return;
        }

        // 🔹 devolvemos directamente el objeto permiso
        $this->response($permiso);
    }

    private function actualizarPermiso() {
        $input = json_decode(file_get_contents("php://input"), true);

        if (
            !$input || 
            !isset($input["idPermiso"]) || 
            !isset($input["idEmpleado"]) || 
            !isset($input["idTipoPermiso"])
        ) {
            $this->response(["success" => false, "error" => "Datos inválidos"]);
            return;
        }

        $ok = $this->permisoModel->actualizarPermiso(
            $input["idPermiso"],
            $input["idEmpleado"],
            $input["idTipoPermiso"],
            $input["fechaInicio"],
            $input["fechaFin"],
            $input["estado"],
            $input["motivo"]
        );

        $this->response(["success" => $ok]);
    }

    private function eliminarPermiso() {
        $input = json_decode(file_get_contents("php://input"), true);
        $idPermiso = $input["idPermiso"] ?? null;

        if (!$idPermiso) {
            $this->response(["success" => false, "error" => "ID no proporcionado"]);
            return;
        }

        $ok = $this->permisoModel->eliminarPermiso($idPermiso);
        $this->response(["success" => $ok]);
    }

    private function tiposPermiso() {
        $data = $this->permisoModel->tiposPermiso();
        $this->response($data);
    }

    private function listarEmpleados() {
        $data = $this->permisoModel->listarEmpleados();
        $this->response($data);
    }

    private function response($data) {
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}

$action = $_GET["action"] ?? null;
$controller = new PermisoController();
$controller->handleRequest($action);

<?php
require_once __DIR__ . '/../model/Permisos.php';

$permiso = new Permisos();

header("Content-Type: application/json; charset=UTF-8");

$action = $_GET["action"] ?? "";

switch ($action) {
    case "listarPermisos":
        echo json_encode($permiso->listarPermisos());
        break;

    case "listarTipos":
        echo json_encode($permiso->obtenerTiposPermiso());
        break;

    case "listarMotivos":
        echo json_encode($permiso->obtenerMotivos());
        break;

    case "registrarPermiso":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            echo json_encode(["success" => false, "error" => "Datos inválidos"]);
            exit;
        }
        echo json_encode($permiso->registrarPermiso($data));
        break;

    case "eliminarPermiso":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["idPermiso"])) {
            echo json_encode(["success" => false, "error" => "ID de permiso requerido"]);
            exit;
        }
        echo json_encode($permiso->eliminarPermiso((int)$data["idPermiso"]));
        break;

    case "getDatosPermiso":
        $id = $_GET["idPermiso"] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "error" => "ID de permiso requerido"]);
            exit;
        }
        echo json_encode($permiso->getDatosPermiso((int)$id));
        break;

    default:
        echo json_encode(["success" => false, "error" => "Acción no válida"]);
        break;
}

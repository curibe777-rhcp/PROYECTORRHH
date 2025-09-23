<?php

require_once __DIR__ . '/../model/Empleado.php';

class EmpleadoController {
    private $empleadoModel;

    public function __construct() {
        $this->empleadoModel = new Empleado();
    }

    public function obtenerTiposDocumento() {
        $tipos = $this->empleadoModel->obtenerTiposDocumento();

        header("Content-Type: application/json");
        echo json_encode($tipos);
    }

    public function obtenerDepartamentos() {
        $departamentos = $this->empleadoModel->obtenerDepartamentos();

        header("Content-Type: application/json");
        echo json_encode($departamentos);
    }

    public function obtenerProvincias() {
        $idDepartamento = $_GET['idDepartamento'] ?? 0;
        $provincias = $this->empleadoModel->obtenerProvinciasPorDepartamento($idDepartamento);

        header("Content-Type: application/json");
        echo json_encode($provincias);
    }

    public function obtenerDistritos() {
        $idProvincia = $_GET['idProvincia'] ?? 0;
        $distritos = $this->empleadoModel->obtenerDistritosPorProvincia($idProvincia);

        header("Content-Type: application/json");
        echo json_encode($distritos);
    }

    public function obtenerAreasTrabajo() {
        $areas = $this->empleadoModel->obtenerAreasTrabajo();

        header("Content-Type: application/json");
        echo json_encode($areas);
    }

    public function obtenerCargos() {
        $idAreaTrabajo = $_GET['idAreaTrabajo'] ?? 0;
        $cargos = $this->empleadoModel->obtenerCargosPorArea($idAreaTrabajo);

        header("Content-Type: application/json");
        echo json_encode($cargos);
    }

    public function obtenerMotivo(){
        $motivos = $this->empleadoModel->obtenerMotivo();
        
        header("Content-Type: application/json");
        echo json_encode($motivos);
    }


    public function registrarEmpleadoUsuario() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos no válidos"]);
            return;
        }

        $resultado = $this->empleadoModel->registrarEmpleadoUsuario($data);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function listarEmpleados() {
        $resultado = $this->empleadoModel->listarEmpleados();

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

    public function retirarEmpleado() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['idEmpleado'], $data['idMotivo'], $data['descripcion'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $idEmpleado = $data['idEmpleado'];
        $idMotivo = $data['idMotivo'];
        $descripcion = $data['descripcion'];

        $resultado = $this->empleadoModel->retirarEmpleado($idEmpleado, $idMotivo, $descripcion);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }


    public function obtenerDatos()
    {
        $idEmpleado = $_GET['idEmpleado'] ?? 0;
        $datos = $this->empleadoModel->getDatosPersonales($idEmpleado);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($datos);
    }


    public function obtenerDatosUbicacion()
    {
        $idEmpleado = $_GET['idEmpleado'] ?? 0;
        $ubicacion = $this->empleadoModel->getDatosUbicacion($idEmpleado);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($ubicacion);
    }

    public function obtenerDatosLaborales()
    {
        $idEmpleado = $_GET['idEmpleado'] ?? 0;
        $laborales = $this->empleadoModel->getDatosLaborales($idEmpleado);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($laborales);
    }

    public function actualizarDatosPersonales() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['idEmpleado'], $data['nombre'], $data['apePaterno'], $data['apeMaterno'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $idEmpleado = $data['idEmpleado'];
        $nombre = $data['nombre'];
        $apePaterno = $data['apePaterno'];
        $apeMaterno = $data['apeMaterno'];

        $resultado = $this->empleadoModel->actualizarDatosPersonales($idEmpleado, $nombre, $apePaterno, $apeMaterno);

        header("Content-Type: application/json");
        echo json_encode($resultado);
    }

    public function actualizarUbicacionEmpleado() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data['idEmpleado'], $data['idDepartamento'], $data['idProvincia'], $data['idDistrito'], $data['direccion'])) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $idEmpleado = $data['idEmpleado'];
        $idDepartamento = $data['idDepartamento'];
        $idProvincia = $data['idProvincia'];
        $idDistrito = $data['idDistrito'];
        $direccion = $data['direccion'];

        $resultado = $this->empleadoModel->actualizarUbicacionEmpleado($idEmpleado, $idDepartamento, $idProvincia, $idDistrito, $direccion);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($resultado);
    }

    public function actualizarDatosLaborales()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data ||
            !isset($data['idEmpleado'], $data['idArea'], $data['idCargo'], $data['telefono'], $data['salario'])
        ) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "Datos incompletos"]);
            return;
        }

        $idEmpleado = $data['idEmpleado'];
        $idArea = $data['idArea'];
        $idCargo = $data['idCargo'];
        $telefono = $data['telefono'];
        $salario = $data['salario'];

        $resultado = $this->empleadoModel->actualizarDatosLaboralesEmpleado($idEmpleado, $idArea, $idCargo, $telefono, $salario);

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($resultado);
    }



}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    $controller = new EmpleadoController();

    if ($action === 'tiposDocumento') {
        $controller->obtenerTiposDocumento();
    } elseif ($action === 'departamentos') {
        $controller->obtenerDepartamentos();
    } elseif ($action === 'provincias') {
        $controller->obtenerProvincias();
    } elseif ($action === 'distritos') {
        $controller->obtenerDistritos();
    } elseif ($action === 'areasTrabajo') {
        $controller->obtenerAreasTrabajo();
    } elseif ($action === 'cargos') {
        $controller->obtenerCargos();
    } elseif ($action === 'listarEmpleados') {
        $controller->listarEmpleados(); 
    } elseif ($action === 'motivos') {
        $controller->obtenerMotivo();
    } elseif ($action === 'datosPersonales') {
        $controller->obtenerDatos();
    } elseif ($action === 'datosUbicacion') {
        $controller->obtenerDatosUbicacion();
    } elseif($action === 'datosLaborales') {
        $controller->obtenerDatosLaborales();
    }


} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';
    $controller = new EmpleadoController();

    if ($action === 'registrarEmpleadoUsuario') {
        $controller->registrarEmpleadoUsuario();
    } elseif ($action === 'retirarEmpleado') {
        $controller->retirarEmpleado();
    } elseif ($action === 'actualizarDatosPersonales') {
        $controller->actualizarDatosPersonales();
    } elseif($action === 'actualizarUbicacion'){
        $controller->actualizarUbicacionEmpleado();
    } elseif ($action === 'actualizarDatosLaborales') {
        $controller->actualizarDatosLaborales();
    }

}

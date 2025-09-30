<?php
require_once __DIR__ . '/../config/ConexionBD.php';

class Permiso {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Listar todos los permisos
    public function listarPermisos() {
        $sql = "CALL sp_listar_permisos()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar un permiso nuevo
    public function registrarPermiso($idEmpleado, $idTipoPermiso, $fechaInicio, $fechaFin, $estado, $motivo) {
        $sql = "CALL sp_registrar_permiso(:idEmpleado, :idTipoPermiso, :fechaInicio, :fechaFin, :estado, :motivo)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(":idTipoPermiso", $idTipoPermiso, PDO::PARAM_INT);
        $stmt->bindParam(":fechaInicio", $fechaInicio);
        $stmt->bindParam(":fechaFin", $fechaFin);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":motivo", $motivo);

        return $stmt->execute();
    }


    // Obtener un permiso por ID
    public function obtenerPermiso($idPermiso) {
        $sql = "CALL sp_obtener_permiso(:idPermiso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idPermiso", $idPermiso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar permiso existente
    public function actualizarPermiso($idPermiso, $idEmpleado, $idTipoPermiso, $fechaInicio, $fechaFin, $estado, $motivo) {
    $sql = "CALL sp_actualizar_permiso(:idPermiso, :idEmpleado, :idTipoPermiso, :fechaInicio, :fechaFin, :estado, :motivo)";
    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(":idPermiso", $idPermiso, PDO::PARAM_INT);
    $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
    $stmt->bindParam(":idTipoPermiso", $idTipoPermiso, PDO::PARAM_INT);
    $stmt->bindParam(":fechaInicio", $fechaInicio);
    $stmt->bindParam(":fechaFin", $fechaFin);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":motivo", $motivo);

    return $stmt->execute();
}

    // Eliminar permiso
    public function eliminarPermiso($idPermiso) {
        $sql = "CALL sp_eliminar_permiso(:idPermiso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idPermiso", $idPermiso, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Listar tipos de permiso
    public function tiposPermiso() {
        $sql = "CALL sp_listar_tipos_permiso()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar empleados activos (para asignar permisos)
    public function listarEmpleados() {
        $sql = "CALL sp_listar_empleados()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php
require_once __DIR__ . '/../config/ConexionBD.php';

class Permiso {
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // ✅ Listar todos los permisos
    public function listarPermisos() {
        try {
            $sql = "CALL sp_listar_permisos()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $permisos ?: [];
        } catch (PDOException $e) {
            error_log("Error en listarPermisos: " . $e->getMessage());
            return [];
        }
    }

    // ✅ Listar tipos de permiso
    public function obtenerTiposPermiso() {
        try {
            $sql = "CALL sp_listar_tipos_permiso()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $tipos ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // ✅ Listar estados de permiso
    public function obtenerEstadosPermiso() {
        try {
            $sql = "CALL sp_listar_estados_permiso()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $estados ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // ✅ Registrar un nuevo permiso
    public function registrarPermiso($data) {
        try {
            $sql = "CALL sp_registrarPermiso(
                :idEmpleado,
                :fechaInicio,
                :fechaFin,
                :idTipoPermiso,
                :motivo,
                :usuario_reg
            )";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idEmpleado", $data["idEmpleado"], PDO::PARAM_INT);
            $stmt->bindParam(":fechaInicio", $data["fechaInicio"], PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin", $data["fechaFin"], PDO::PARAM_STR);
            $stmt->bindParam(":idTipoPermiso", $data["idTipoPermiso"], PDO::PARAM_INT);
            $stmt->bindParam(":motivo", $data["motivo"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario_reg", $data["usuario_reg"], PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Permiso registrado correctamente"];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // ✅ Aprobar / Rechazar permiso
    public function actualizarEstado($idPermiso, $idEstadoPermiso, $usuario_mod) {
        try {
            $sql = "CALL sp_actualizarEstadoPermiso(:idPermiso, :idEstadoPermiso, :usuario_mod)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idPermiso", $idPermiso, PDO::PARAM_INT);
            $stmt->bindParam(":idEstadoPermiso", $idEstadoPermiso, PDO::PARAM_INT);
            $stmt->bindParam(":usuario_mod", $usuario_mod, PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Estado actualizado correctamente"];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}

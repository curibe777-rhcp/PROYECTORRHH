<?php
require_once __DIR__ . '/../config/ConexionBD.php';

class Contrato
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    // --------------------------------------------------------------------------------------//
    // REGISTRO DE CONTRATOS
    public function registrarContrato($data)
    {
        try {
            $sql = "CALL sp_registrar_contrato(
                :idEmpleado,
                :fechaInicio,
                :fechaFin,
                :idTipoContrato,
                :idEstadoContrato,
                :usuarioReg
            )";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idEmpleado", $data["idEmpleado"], PDO::PARAM_INT);
            $stmt->bindParam(":fechaInicio", $data["fechaInicio"], PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin", $data["fechaFin"], PDO::PARAM_STR);
            $stmt->bindParam(":idTipoContrato", $data["idTipoContrato"], PDO::PARAM_INT);
            $stmt->bindParam(":idEstadoContrato", $data["idEstadoContrato"], PDO::PARAM_INT);
            $stmt->bindParam(":usuarioReg", $data["usuarioReg"], PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Contrato registrado correctamente."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // ACTUALIZACION DE CONTRATOS
    public function actualizarContrato($data)
    {
        try {
            $sql = "CALL sp_actualizar_contrato(
                :idContrato,
                :fechaInicio,
                :fechaFin,
                :idTipoContrato,
                :idEstadoContrato,
                :usuarioMod
            )";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idContrato", $data["idContrato"], PDO::PARAM_INT);
            $stmt->bindParam(":fechaInicio", $data["fechaInicio"], PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin", $data["fechaFin"], PDO::PARAM_STR);
            $stmt->bindParam(":idTipoContrato", $data["idTipoContrato"], PDO::PARAM_INT);
            $stmt->bindParam(":idEstadoContrato", $data["idEstadoContrato"], PDO::PARAM_INT);
            $stmt->bindParam(":usuarioMod", $data["usuarioMod"], PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Contrato actualizado correctamente."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // LISTAR CONTRATOS
    public function listarContratos()
    {
        try {
            $sql = "CALL sp_listar_contratos()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $result ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // OBTENER CONTRATOS POR EMPLEADO
    public function obtenerContratosPorEmpleado($idEmpleado)
    {
        try {
            $sql = "CALL sp_obtener_contratos_por_empleado(:idEmpleado)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $result ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // CAMBIAR ESTADO DE CONTRATO
    public function cambiarEstadoContrato($idContrato, $idEstadoContrato, $usuarioMod = 1)
    {
        try {
            $sql = "CALL sp_cambiar_estado_contrato(
                :idContrato,
                :idEstadoContrato,
                :usuarioMod
            )";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":idContrato", $idContrato, PDO::PARAM_INT);
            $stmt->bindParam(":idEstadoContrato", $idEstadoContrato, PDO::PARAM_INT);
            $stmt->bindParam(":usuarioMod", $usuarioMod, PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Estado del contrato actualizado correctamente."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // LISTAR TIPOS DE CONTRATO
    public function obtenerTiposContrato()
    {
        try {
            $sql = "CALL sp_listar_tipo_contrato()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $result ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // --------------------------------------------------------------------------------------//
    // LISTAR ESTADOS DE CONTRATO
    public function obtenerEstadosContrato()
    {
        try {
            $sql = "CALL sp_listar_estado_contrato()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $result ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}

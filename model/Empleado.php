<?php

require_once __DIR__ . '/../config/ConexionBD.php';

class Empleado {
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function obtenerTiposDocumento() {
        try {
            $sql = "CALL sp_obtener_tipos_documento()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $resultados ?: [];

        } catch (PDOException $e) {
            return ["Error" => $e->getMessage()];
        }
    }

    public function obtenerDepartamentos() {
        try {
            $sql = "CALL sp_obtener_departamentos()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $departamentos;
        } catch (PDOException $e) {
         return ["Error" => $e->getMessage()];
        }
    }

    public function obtenerProvinciasPorDepartamento($idDepartamento) {
        try {
            $sql = "CALL sp_obtener_provincias_por_departamento(:idDepartamento)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":idDepartamento", $idDepartamento, PDO::PARAM_INT);
            $stmt->execute();
            $provincias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $provincias;
        } catch (PDOException $e) {
            return ["Error" => $e->getMessage()];
        }
    }

    public function obtenerDistritosPorProvincia($idProvincia) {
        try {
            $sql = "CALL sp_obtener_distritos_por_provincia(:idProvincia)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":idProvincia", $idProvincia, PDO::PARAM_INT);
            $stmt->execute();
            $distritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $distritos;
        } catch (PDOException $e) {
            return ["Error" => $e->getMessage()];
        }
    }

    public function obtenerAreasTrabajo() {
        try {
            $sql = "CALL sp_obtener_areas_de_trabajo()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $areas;
        } catch (PDOException $e) {
            return ["Error" => $e->getMessage()];
        }
    }

    public function obtenerCargosPorArea($idAreaTrabajo) {
        try {
            $sql = "CALL sp_obtener_cargos_por_area(:idAreaTrabajo)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":idAreaTrabajo", $idAreaTrabajo, PDO::PARAM_INT);
            $stmt->execute();
            $cargos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $cargos;
        } catch (PDOException $e) {
            return ["Error" => $e->getMessage()];
        }
    }


    public function registrarEmpleadoUsuario($data) {
        try {
            $sql = "CALL sp_registrarEmpleadoUsuario(
                :nombres, 
                :apellidoPaterno, 
                :apellidoMaterno, 
                :idTipoDocumento, 
                :numeroDocumento, 
                :idDepartamento, 
                :idProvincia, 
                :idDistrito, 
                :direccion, 
                :telefono, 
                :email, 
                :fechaNacimiento, 
                :idAreaTrabajo, 
                :idCargo, 
                :salario, 
                :usuario_reg
            )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":nombres", $data["nombres"], PDO::PARAM_STR);
            $stmt->bindParam(":apellidoPaterno", $data["apellidoPaterno"], PDO::PARAM_STR);
            $stmt->bindParam(":apellidoMaterno", $data["apellidoMaterno"], PDO::PARAM_STR);
            $stmt->bindParam(":idTipoDocumento", $data["idTipoDocumento"], PDO::PARAM_INT);
            $stmt->bindParam(":numeroDocumento", $data["numeroDocumento"], PDO::PARAM_STR);
            $stmt->bindParam(":idDepartamento", $data["idDepartamento"], PDO::PARAM_INT);
            $stmt->bindParam(":idProvincia", $data["idProvincia"], PDO::PARAM_INT);
            $stmt->bindParam(":idDistrito", $data["idDistrito"], PDO::PARAM_INT);
            $stmt->bindParam(":direccion", $data["direccion"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $data["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(":email", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":fechaNacimiento", $data["fechaNacimiento"], PDO::PARAM_STR);
            $stmt->bindParam(":idAreaTrabajo", $data["idAreaTrabajo"], PDO::PARAM_INT);
            $stmt->bindParam(":idCargo", $data["idCargo"], PDO::PARAM_INT);
            $stmt->bindParam(":salario", $data["salario"]);
            $stmt->bindParam(":usuario_reg", $data["usuario_reg"], PDO::PARAM_INT);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Empleado y usuario registrados correctamente."];

        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function listarEmpleados() {
        try {
            $stmt = $this->conn->prepare("CALL sp_listar_empleados()");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtenerMotivo() {
        try {
            $sql = "CALL sp_listar_tipo_motivo()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $motivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $motivos;
        } catch (PDOException $e) {
         return ["Error" => $e->getMessage()];
        }
    }

    public function retirarEmpleado($idEmpleado, $idMotivo, $descripcion) {
        try {
            $sql = "CALL sp_retirar_empleado(:idEmpleado, :idMotivo, :descripcion)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmt->bindParam(':idMotivo', $idMotivo, PDO::PARAM_INT);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

            $stmt->execute();
            $stmt->closeCursor();

            return ["success" => true, "message" => "Empleado retirado correctamente"];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function getDatosPersonales(int $idEmpleado): ?array
    {
        $sql = "CALL sp_getDatosPersonales(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idEmpleado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $row ?: null;
        
    }


    public function getDatosUbicacion($idEmpleado)
    {
        try {
            $stmt = $this->conn->prepare("CALL sp_getDatosUbicacion(:idEmpleado)");
            $stmt->bindParam(":idEmpleado", $idEmpleado, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result ?: [];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }


}
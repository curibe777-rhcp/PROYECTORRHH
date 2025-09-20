<?php

    require_once __DIR__ . '/../config/ConexionBD.php';

    class Usuario {
        private $conn;

        public function __construct()
        {
            $this->conn = (new Database())->getConnection();
        }

        public function validarLogin($usuario, $clave){
            try {
                $sql = "CALL sp_validar_login(:usuario, :clave)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
                $stmt->bindParam(":clave", $clave, PDO::PARAM_STR);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt->closeCursor();

                return $row ?: false;

            } catch (PDOException $e) {
                return ["Error" => $e->getMessage()];
            }
        }
    }
?>
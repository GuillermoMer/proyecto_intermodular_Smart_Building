<?php

require_once './model/conexion.php';
require_once './class/user.php';


class GrupoModel {
    private $conexion;

    public function __construct() {
        $this->conexion = ConectarDB::conexion();
    }

    public function getGruposPorUsuario($email) {
        $sql= "SELECT DISTINCT(NOM_GRUPO) FROM AGRUPACIONES WHERE EMAIL = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function aulasGrupo($nomgrupo ,$email){
        $sql='SELECT COD_EST FROM AGRUPACIONES WHERE NOM_GRUPO= :nombre AND EMAIL =:email ORDER BY COD_EST' ;
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nomgrupo);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function crearGrupo($nombre, $estancia, $desc, $email,){
        if(empty($nombre)||empty($estancia)||empty($email)){
            return;
        }
        $sqlC= "SELECT COUNT(*) FROM AGRUPACIONES WHERE NOM_GRUPO = :nombre AND EMAIL = :email";
        $stmtC = $this->conexion->prepare($sqlC);  
        $stmtC->bindParam(':nombre', $nombre);
        $stmtC->bindParam(':email', $email);
        $stmtC->execute();
        $existe = $stmtC->fetchColumn();
        if ($existe > 0) {
            return;
        }
        $sql= "INSERT INTO AGRUPACIONES (NOM_GRUPO, DESCR, COD_EST, EMAIL) VALUES (:nombre, :descr, :estancia, :email)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descr', $desc);
        $stmt->bindParam(':estancia', $estancia);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
    public function addToGrupo($estancia, $grupo, $email){
        if(empty($estancia) || empty($grupo) || empty($email)){
            return;
        }
        $sqlC= "SELECT COUNT(*) FROM AGRUPACIONES WHERE COD_EST= :estancia AND NOM_GRUPO = :nombre AND EMAIL = :email";
        $stmtC = $this->conexion->prepare($sqlC);  
        $stmtC->bindParam(':estancia', $estancia);
        $stmtC->bindParam(':nombre', $grupo);
        $stmtC->bindParam(':email', $email);
        $stmtC->execute();
        $existe = $stmtC->fetchColumn();
        if ($existe > 0) {
            return;
        }
        $sql= "INSERT INTO AGRUPACIONES (NOM_GRUPO, COD_EST, EMAIL) VALUES (:nombre, :estancia, :email)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $grupo);
        $stmt->bindParam(':estancia', $estancia);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

    }

}
?> 
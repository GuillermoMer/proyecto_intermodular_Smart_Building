<?php

require_once ROOT . 'model/conexion.php';
require_once ROOT . 'class/user.php';


class GraficModel {
    private $conexion;

    public function __construct() {
        $this->conexion = ConectarDB::conexion();
    }

    public function verAulas(){ 
        $sql= "SELECT e.COD_EST, tp.TEMP AS temp_programada, l.TEMP_ACT AS temp_real FROM ESTANCIAS e
        INNER JOIN TEMP_PROG tp ON tp.COD_EST = e.COD_EST
            AND tp.FECHA = (SELECT MAX(FECHA) FROM TEMP_PROG WHERE COD_EST = e.COD_EST)
            AND tp.HORA = (SELECT HORA FROM TEMP_PROG WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
            AND tp.MINUT = (SELECT MINUT FROM TEMP_PROG WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
        INNER JOIN LECTURAS l ON l.COD_EST = e.COD_EST
            AND l.FECHA = (SELECT MAX(FECHA) FROM LECTURAS WHERE COD_EST = e.COD_EST)
            AND l.HORA = (SELECT HORA FROM LECTURAS WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
            AND l.MINUT = (SELECT MINUT FROM LECTURAS WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1);";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verEstancias(){
        $sql="SELECT COD_EST FROM ESTANCIAS ORDER BY COD_EST";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verTempe(){
        $sql="SELECT COD_EST, TEMP_ACT FROM LECTURAS GROUP BY COD_EST ORDER BY FECHA, HORA, MINUT;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function nuevaTemp($nuevaTemp,$estancia){
        
        if ( empty($nuevaTemp)|| empty($estancia)) {
            return;
        }
        $sql = "INSERT INTO TEMP_PROG (TEMP, FECHA, HORA, MINUT, SEG, COD_EST) VALUES (:temp, CURDATE(), HOUR(CURTIME()), MINUTE(CURTIME()), SECOND(CURTIME()), :cod_est)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cod_est', $estancia);
        $stmt->bindParam(':temp', $nuevaTemp);
        $stmt->execute();
    }

    //recoge el numero de radiadores para sumarlo o restarlo cada vez que hay un cambio
    public function radiadores(){
        $sql=" SELECT N_RAD FROM ESTANCIAS GROUP BY COD_EST";
        $stmt=$this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function valv(){
        $sql="SELECT FECHA_INI, HORA, MINUT, COD_EST, EST_VALVULA, N_RAD FROM ESTADOS_VAL JOIN ESTANCIAS USING (COD_EST) ORDER BY FECHA_INI, HORA, MINUT  ";
        $stmt=$this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function tempAula($aula){
        if(empty($aula)){
            return;
        }
        $sql= "SELECT e.COD_EST, tp.TEMP AS temp_programada, l.TEMP_ACT AS temp_real FROM ESTANCIAS e
            INNER JOIN TEMP_PROG tp ON tp.COD_EST = e.COD_EST
                AND tp.FECHA = (SELECT MAX(FECHA) FROM TEMP_PROG WHERE COD_EST = e.COD_EST)
                AND tp.HORA = (SELECT HORA FROM TEMP_PROG WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
                AND tp.MINUT = (SELECT MINUT FROM TEMP_PROG WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
            INNER JOIN LECTURAS l ON l.COD_EST = e.COD_EST
                AND l.FECHA = (SELECT MAX(FECHA) FROM LECTURAS WHERE COD_EST = e.COD_EST)
                AND l.HORA = (SELECT HORA FROM LECTURAS WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1)
                AND l.MINUT = (SELECT MINUT FROM LECTURAS WHERE COD_EST = e.COD_EST ORDER BY FECHA DESC, HORA DESC, MINUT DESC LIMIT 1) WHERE e.COD_EST= :aula";
        $stmt= $this->conexion->prepare($sql);
        $stmt->bindParam(':aula',$aula);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verCaldera(){
        $sql="SELECT EST_VALVULA FROM ESTADOS_CAL ORDER BY FECHA_INI DESC, HORA DESC, MINUT DESC LIMIT 1";
        $stmt=$this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*-grafica temperaturas-*/

    public function graficaTemperatura($aula){
        if(empty($aula)){   
            return;
        }
        $sql="SELECT TEMP_ACT, FECHA, HORA, MINUT, COD_EST FROM LECTURAS WHERE COD_EST=:aula ORDER BY FECHA, HORA, MINUT";
        $stmt=$this->conexion->prepare($sql);
        $stmt->bindParam(':aula', $aula);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



}
?> 
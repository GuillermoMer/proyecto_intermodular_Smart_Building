<?php
//Clase Conectar: Establece la conexión con la base de datos utilizando PDO.

class ConectarDB {
    //Creamos una variable estatica para controlar que solamente tenememos una conexión activa
    private static $conexion=null;

    public static function conexion() {
        //Si ya hay una conexión activa, no volvemos a crear la conexión
        if(self::$conexion===null){
            try {
                // Crear la conexión PDO
                self::$conexion = new PDO("mysql:host=localhost;dbname=smartbuilding;charset=utf8", "root", "");
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
            } catch (PDOException $e) {
                die("Error al conectar con la base de datos: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
?>

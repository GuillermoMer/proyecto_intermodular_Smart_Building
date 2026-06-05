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
				$host     = "PMYSQL202.dns-servicio.com:3306"; 
                $port     = "3306";
				$dbname   = "11407392_smartbuilding"; 
                $user     = "GuillermoMerchanteAlbacete";          
                $password = "Guillermo1+234"; 
                $charset  = "utf8";
				
				// Construimos el DSN apuntando localmente
                $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

                // Crear la conexión PDO con las credenciales reales
                self::$conexion = new PDO($dsn, $user, $password);
                self:
            } catch (PDOException $e) {
                die("Error al conectar con la base de datos: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
?>
<?php
require_once ROOT . "model/conexion.php";
require_once ROOT . "class/user.php";




class UserModel {
    private $conexionDB;

    public function __construct() {
        $this->conexionDB = ConectarDB::conexion();
    }

    public function comprobarUser($email, $pass) {
        $sql= 'SELECT email FROM USUARIOS WHERE email=:email AND password=:pass';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function comprobarRol($email) {

        $sql= 'SELECT ID_ROL FROM USUARIOS WHERE EMAIL=:email';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

    public function usuario($email){
        $sql='SELECT NOMBRE FROM USUARIOS WHERE EMAIL= :email';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function mostrarUsuarios($rol){
        $sql= 'SELECT EMAIL, NOMBRE, APELLIDOS, ID_ROL FROM USUARIOS WHERE ID_ROL >= :rol';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrar($email, $nombre, $apellidos, $password, $rol){
        if (empty($email) || empty($nombre) || empty($apellidos) || empty($password)) {
            return;
        }
        if(empty($rol)||$rol==1){
            $rol=3;
        }
        $sqlC= 'SELECT COUNT(*) FROM USUARIOS WHERE EMAIL = :email';
        $stmtC = $this->conexionDB->prepare($sqlC);  
        $stmtC->bindParam(':email', $email);
        $stmtC->execute();
        $existe = $stmtC->fetchColumn();
        if ($existe > 0) {
            return;
        }
        $sql= 'INSERT INTO USUARIOS (EMAIL, NOMBRE, APELLIDOS, PASSWORD, ID_ROL) VALUES (:email, :nombre, :apellidos, :password, :rol)';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
    }
    public function edit($email, $nombre, $apellidos, $password, $rol){

        if(empty($email)){
            return;
        }
        
        $sqlC="SELECT * FROM USUARIOS WHERE EMAIL= :email ";
        $stmtC = $this->conexionDB->prepare($sqlC);
        $stmtC->bindParam(':email', $email);
        $stmtC->execute();
        $actual=$stmtC->fetch(PDO::FETCH_ASSOC);
   

        if (empty($nombre)) {
            $nombre=$actual['NOMBRE'];
        }
        if(empty($apellidos)){
            $apellidos=$actual['APELLIDOS'];
        }
        if(empty($password)){
            $password=$actual['PASSWORD'];
        }
        if(empty($rol)) {
            $rol=$actual['ID_ROL'];
        }
		$rol = (int)$rol;
    	$rolActual = (int)$actual['ID_ROL'];

        if($rol!==1 && $rol!==2 && $rol!==3){
            return;
        }
        if($rol===1 &&$rolActual!==1){ 
           return;
        }
        $sql= 'UPDATE USUARIOS SET NOMBRE = :nombre, APELLIDOS = :apellidos, PASSWORD = :password, ID_ROL = :rol WHERE EMAIL = :email';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();
    }

     public function borrar($email){

        $sql = 'DELETE FROM USUARIOS WHERE EMAIL = :email';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    public function obtenerUsuarioEntidad($email, $pass) {
        if(empty($email)||empty($pass)){
            return;
        } 
        $sql = 'SELECT * FROM USUARIOS WHERE EMAIL = :email  LIMIT 1';
        $stmt = $this->conexionDB->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute(); 
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        

        if (!$fila) {
            return null;
        }
        if (!$fila || !password_verify($pass, $fila['PASSWORD'])) {
            throw new Exception("Credenciales incorrectas"); // mismo mensaje para ambos casos
        }
        return new User($fila['EMAIL'], (int) $fila['ID_ROL']);
    }

 
}
?>
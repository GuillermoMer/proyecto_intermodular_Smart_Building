<?php
//guardar aqui email y rol para sacarlo en los controles e info
class User {
    private $email;
    private $rol;

    public function __construct($email, $rol) {
        $this->email = $email;
        $this->rol = $rol;
    }

    public function getMail() {
        return $this->email;
    }

    public function setMail($email) {
        $this->email = $email;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}
?>
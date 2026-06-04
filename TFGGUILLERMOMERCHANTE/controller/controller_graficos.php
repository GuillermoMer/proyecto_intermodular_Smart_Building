<?php
 require_once './class/user.php';
 require_once './model/modelGrupo.php';
 require_once './model/modelUser.php';
 require_once './model/modelGrafics.php';

    class GraficosController{

        public function usuarioActual(){
            if (!isset($_SESSION['usuario_obj'])) {
                return null;
            }

            $usuario = @unserialize($_SESSION['usuario_obj'], ['allowed_classes' => ['User']]);
            if ($usuario instanceof User) {
                return $usuario;
            }

            return null;
        }

        private function rolActual(){
            $usuario = $this->usuarioActual();
            return $usuario ? (int) $usuario->getRol() : null;
        }


        public function login(){
            
            $email = $_POST['email'] ?? $_GET['email'] ?? null;
            $pass = $_POST['pass'] ?? $_GET['pass'] ?? null;

            if (empty($email) || empty($pass)) {
                header('Location: ./index.php?action=home&error=credenciales');
                return;
            }
            //$hash = password_hash($pass, PASSWORD_ARGON2ID);
            $usuarioModel= new UserModel();
            $usuarioEntidad = $usuarioModel->obtenerUsuarioEntidad($email, $pass); 

            if (!$usuarioEntidad) {
                header('Location: ./index.php?action=home&error=invalidas');
                return;
            }

            $_SESSION['usuario_obj'] = serialize($usuarioEntidad);
        //tanto al iniciar sesion como al registrarse el usuario será enviado a su perfil

            header('Location: ./index.php?action=perfil');
            exit;
        }

        public function nuevoGrupo(){
            $grupoModel= new GrupoModel();
            $grupoModel->crearGrupo($_POST['nombre'], $_POST['estancia'], $_POST['desc'] , $this->usuarioActual()->getMail());
            header('Location: ./index.php?action=perfil');
        }
    
        public function home(){
            $graficsModel= new GraficModel();
            $tempes=$graficsModel->verTempe(); 
            require_once './views/home.php';
        }

        public function grafic(){
            $graficsModel= new GraficModel();
            $estancias= $graficsModel->verEstancias();
            $grupoModel = new GrupoModel();
            $grupos=$grupoModel->getGruposPorUsuario($this->usuarioActual()->getMail()); 

            require_once './views/graphics.php';
        }

        public function users(){
            $rol=$this->rolActual();
            $usermodel= new UserModel();
            $usuarios = $usermodel->mostrarUsuarios($rol); 
            require_once './views/users.php';
        }

        public function tempe(){
            $graficsModel= new GraficModel();
            $aulas = $graficsModel->verAulas();
            $estancias= $graficsModel->verEstancias();
            require_once './views/confort.php';
        }


        public function perfil(){ 
            $grupoModel = new GrupoModel();
            $graficsModel = new GraficModel();
            $userModel = new UserModel();
            $grupos = $grupoModel->getGruposPorUsuario($this->usuarioActual()->getMail());
            $estancias=$graficsModel->verEstancias();
            $ver = $userModel->usuario($this->usuarioActual()->getMail());
            require_once './views/profile.php';
        }

        public function crear(){
            $userModel= new UserModel();
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            if(strlen($password)<8){
                return;
            } 
            $contraSegura= password_hash($password, PASSWORD_ARGON2ID);
            $rol = $_POST['rol'];   

            $userModel->registrar($email, $nombre, $apellidos, $contraSegura, $rol);
            header('Location: ./index.php?action=users');
        }

        public function registrar(){
            $userModel= new UserModel();
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            if(strlen($password)<8){
                return;
            }
            $contraSegura= password_hash($password, PASSWORD_ARGON2ID);

            $userModel->registrar($email, $nombre, $apellidos, $contraSegura, 3);
            $usuarioEntidad= $userModel->obtenerUsuarioEntidad($email, $contraSegura);
            $_SESSION['usuario_obj'] = serialize($usuarioEntidad);
            $userModel->usuario($this->usuarioActual()->getMail());
            header('Location: ./index.php?action=perfil');
        }

        public function editar(){
            $userModel= new UserModel();
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            $rol = $_POST['rol'] ?? 3;
 
            if (!empty($password)) {
                if(strlen($password)<8){
                    return;
                }
                $contraSegura = password_hash($password, PASSWORD_ARGON2ID);
                $userModel->edit($email, $nombre, $apellidos, $contraSegura, $rol);
            } else {
                $userModel->edit($email, $nombre, $apellidos, null, $rol);
            }
            header('Location: ./index.php?action=users');
        }
        public function borrar(){ 
            $userModel= new UserModel();
            $emailActual = $this->usuarioActual()->getMail();
            $email=$_POST['email'];

            if($email===$emailActual){
               header('Location: ./index.php?action=users&error=error');
                return;
            }
            $userModel->borrar($email); 
            header('Location: ./index.php?action=users');
        }

        public function cambiarTemp(){
            $graficsModel= new GraficModel();
            $nuevaTemp = $_POST['nuevaT'];
            if($nuevaTemp<=15){
                $nuevaTemp = 15;
            } elseif($nuevaTemp>=24){
                $nuevaTemp = 24;
            }
            $estancia = $_POST['estancia'];
            $graficsModel->nuevaTemp($nuevaTemp, $estancia);
            header('Location: ./index.php?action=tempe');
        }

        public function addtoGrupo($grupo){ 
            $grupoModel = new GrupoModel();
            $estancia = $_POST['aula'];
            $grupoModel->addToGrupo($estancia,$grupo,$this->usuarioActual()->getMail());
            
            header('Location: ./index.php?action=grafic');
        }

        public function logout(){
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            }
            session_destroy();
            header('Location: ./index.php?action=home');
            exit;
        }
    }

?>
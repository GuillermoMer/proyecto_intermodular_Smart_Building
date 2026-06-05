<?php
define('ROOT', __DIR__ . '/');
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


require_once ROOT . 'class/user.php';
require_once ROOT . 'controller/controller_graficos.php';
require_once ROOT . 'api/apiController.php';


$apiController = new ApiController();
$partes = $apiController->extraerApi();
$apiAction = $partes[2] ?? null;
$apiCod = $partes[3] ?? null;

// Prioriza llamadas REST tipo /index.php/forms/{action}/{cod}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['action']) && $apiAction !== null) {
    
    if (method_exists($apiController, $apiAction)) {
        if($apiCod!==null){
            $apiController->$apiAction($apiCod);
        }else{
            $apiController->$apiAction();
        }
    } else {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => 'Accion API no encontrada']);
    }
    exit;
}

$controller = new GraficosController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'home';
} else {
    $action = $_GET['action'] ?? 'home';
}

$usuarioSesion = null;
if (isset($_SESSION['usuario_obj'])) {
    $tmpUsuario = @unserialize($_SESSION['usuario_obj'], ['allowed_classes' => ['User']]);
    if ($tmpUsuario instanceof User) {
        $usuarioSesion = $tmpUsuario;
    }
}

$rol = $usuarioSesion ? (int) $usuarioSesion->getRol() : null;
$permitidasVisitante = ['home', 'login', 'registrar'];
$permitidasUsuario = ['home', 'grafic', 'addtoGrupo', 'perfil', 'nuevoGrupo', 'logout'];
$permitidasAdmin = ['home', 'grafic', 'addtoGrupo', 'users','tempe','perfil', 'nuevoGrupo', 'logout', 'cambiarTemp', 'crear', 'editar', 'borrar'];
$permitidasSuperAdmin=['home', 'grafic','addtoGrupo', 'users','tempe','perfil','nuevoGrupo', 'logout', 'cambiarTemp',  'crear', 'editar', 'borrar'];

if ($rol === 1) {
    $permitidas = $permitidasSuperAdmin;
}elseif($rol===2){
    $permitidas = $permitidasAdmin;
} elseif ($rol === 3) {
    $permitidas = $permitidasUsuario;
} else {
    $permitidas = $permitidasVisitante;
}

if (!in_array($action, $permitidas, true)) {
    header('Location: ./index.php?action=home');
    exit;
}

if (method_exists($controller, $action)) {
    if(isset($_GET["grupo"])){
        $grupo=$_GET["grupo"];

        $controller->$action($grupo);
        //ejecutarAccion($controller, $action, $id);
    }else{
        $controller->$action();
    }

} else {
    $controller->home();
}

?>
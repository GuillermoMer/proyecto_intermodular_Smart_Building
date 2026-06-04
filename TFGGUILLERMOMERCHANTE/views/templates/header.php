
<div class="cabecera">
    <a aria-label="Logo_Cifp" href="https://www.cifpcuenca.es/"><img src="./src/cifpcuencanro1.png" alt="mondongo"></a>

    <h1>PROYECTO SMART BUILDING</h1>

<?php 
    require_once './class/User.php';

$usuarioEntidad = null;
if (isset($_SESSION['usuario_obj'])) {
    $tmpUsuario = @unserialize($_SESSION['usuario_obj'], ['allowed_classes' => ['User']]);
    if ($tmpUsuario instanceof User) {
        $usuarioEntidad = $tmpUsuario;
    }
}

$usuario = $usuarioEntidad ? $usuarioEntidad->getMail() : null;
?>

        <?php if ($usuario): ?>
                   
            <button id="btnLogout"><a href="./index.php?action=logout">CERRAR SESION</a></button>
        <?php else: ?>
            <button id="btnLogin" data-bs-toggle="modal" data-bs-target="#loginModal">INICIA SESION</button>
        <?php endif; ?>
    </div>


</div>
<nav aria-label="Navegación principal">
    <div>
        <ul>
            <li><a aria-label="Ir a inicio" class="nav-link" href="./index.php?action=home">INICIO</a></li>
            <li><a aria-label="Ver gráficas" class="nav-link" href="./index.php?action=grafic">GRAFICAS</a></li>
            <li><a aria-label="Gestión de usuarios" class="nav-link" href="./index.php?action=users">USUARIOS</a></li>
            <li><a aria-label="Ver temperaturas" class="nav-link" href="./index.php?action=tempe">TEMPERATURAS</a></li>
            <li><a aria-label="Ver perfil de usuario" class="nav-link" href="./index.php?action=perfil">PERFIL</a></li>
        </ul>
    </div>
</nav>
<script defer>
    const links = document.querySelectorAll('.nav-link');

    links.forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
    });
</script>
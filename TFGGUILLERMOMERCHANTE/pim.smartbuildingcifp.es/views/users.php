<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link rel="stylesheet" href="/views/styles/styles.css">
    <link rel="stylesheet" href="/views/styles/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js" defer></script>

 
</head>
<body id="usuarios"> 
    <header>
        <?php require_once ROOT . 'views/templates/header.php'; ?>
    </header>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <strong>NO INTENTES BORRARTE A TI MISMO</strong><br>
            <strong>NO TOQUES, ¿POR QUÉ TOCAS?</strong>
        </div>
    <?php endif; ?>
    <main>
       
        <div class="container">
            <div class="contenido">
                <h1>LISTADO DE USUARIOS REGISTRADOS</h1>
                <p>En esta página se muestran todos los usuarios registrados en el sistema, en caso de no ser el superadmin este usuario no se mostraá por motivos de seguridad.</p>
                <p>Desde aquí se dará la opcion de crear, editar y eliminar usuarios <strong>se recomienda no eliminarse a uno mismo</strong></p>
                <p>La opción de crear un usuario como admin contiene la diferencia de poder asignarle el rol deseado mientras que un usuario normal al crear una cuenta recibirá automáticamente rol de registrado</p>


            </div>
        </div>
    </main> <br>
    <section id="confor_table">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th  class="text-start fondo"   >
                        <button type="button" id="crear" data-bs-toggle="modal" data-bs-target="#crearModal">Crear usuario</button>
                    </th>
                    <th  class="text-center fondo" colspan="2">
                        <button type="button" id="editar" data-bs-toggle="modal" data-bs-target="#editModal">Editar usuario</button>
                    </th>
                    <th  class="text-end fondo">
                        <button type="button" id="borrar" data-bs-toggle="modal" data-bs-target="#borrarModal">Borrar usuario</button>
                    </th>
                    
                </tr>
                <tr>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>         
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['EMAIL']; ?></td>
                    <td><?php echo $usuario['NOMBRE']; ?></td>
                    <td><?php echo $usuario['APELLIDOS']; ?></td>
                    <td><?php echo $usuario['ID_ROL']; ?></td>
                </tr>
                <?php endforeach; ?>
 
            </tbody>
        </table>
    </section>
    <?php require_once ROOT . 'views/modales.php'?>
    <?php require_once ROOT . 'views/templates/footer.php'; ?>
    
</body>
</html> 
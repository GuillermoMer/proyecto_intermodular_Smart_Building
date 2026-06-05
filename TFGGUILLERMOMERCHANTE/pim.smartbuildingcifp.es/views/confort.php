<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temperatura</title>
    
    <link rel="stylesheet" href="/views/styles/styles.css">
    <link rel="stylesheet" href="/views/styles/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js" defer></script>



</head> 
<body>
    <header>
        <?php require_once ROOT . 'views/templates/header.php'; ?>
    </header>
    <main>
        <div class="container">
            <div class="contenido">
                <h1>Temperaturas de Confort</h1>
                <p>Aquí podemos ver la temperatura de las aulas registradas así como cual es la temperatura de confort asignada</p>
                <p>A la hora de cambiarla recuerde que este valor indica hasta qué temperatura estarán los radiadores en funcionamiento. <br> 
                Se ruega se tenga en cuenta de qué aula se trata pues <strong> no todas necesitan los radiadores hasta 24 grados </strong></p>

            </div>
        </div>
        
    </main>
    <br>
    <section id="confor_table">


        <table class="table table-striped">
            <thead>
                <tr>
                   <th id="act" colspan="3">
                        <button type="button" id="cambio" data-bs-toggle="modal" data-bs-target="#cambioModal">Actualizar</button>
                    </th>
                </tr>
                <tr>
                    <th>Aula</th>
                    <th>Temperatura Actual</th>
                    <th>Temperatura de Confort</th>         
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aulas as $aula): ?>
                <tr>
                    <td><?php echo $aula['COD_EST']; ?></td>
                    <td><?php echo $aula['temp_real']; ?>°C</td>
                    <td><?php echo $aula['temp_programada']; ?>°C</td>
                </tr>
                <?php endforeach; ?>
 
            </tbody>
        </table>
    </section>

        <?php require_once ROOT . 'views/modales.php'?>
    <footer>
         <?php require_once ROOT . 'views/templates/footer.php'; ?>
    </footer>
</body>
</html>
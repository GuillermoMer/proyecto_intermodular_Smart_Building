<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <link rel="stylesheet" href="./views/styles/styles.css">
    <link rel="stylesheet" href="./views/styles/bootstrap.min.css">
    <script src="./js/bootstrap.bundle.min.js" defer></script>
    <script src="./js/d3.v7.min.js" defer></script>
    <script type="module" src="./js/temperaturas.js" defer></script>



</head>
<body>
    <header>
        <?php require_once './views/templates/header.php'; ?>
    </header>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert">
        Credenciales invalidas. Intentalo de nuevo.
    </div>
<?php endif; ?>

    <main>

        <div class="container">
            <div class="contenido">
                <h1>PROYECTO SMART BUILDING</h1>
                
                <p>El proyecto smart building nace de la intención de mejorar la eficiencia energética del centro y mejorar las condiciones de alumnos y profesores controlando las temperatuas de las aulas para no mantener los radiadores encendidos.</p>
                <p></p>
            </div>
        </div>

    </main>
    <section aria-label="temperaturas" id="temperaturas" class="carruseles">
        <div id="carruselCards" class="carousel slide" data-bs-ride="carousel">
           
           
        </div>
            <!-- Controles -->
            <button aria-label="anterior" class="carousel-control-prev" type="button" data-bs-target="#carruselCards" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button aria-label="siguiente" class="carousel-control-next" type="button" data-bs-target="#carruselCards" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
    </div><br>
    </section>

    <?php require_once './views/modales.php'?>
    <footer>
         <?php require_once './views/templates/footer.php'; ?>
    </footer>
</body>
</html>
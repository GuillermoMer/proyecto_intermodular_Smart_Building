<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    
    <link rel="stylesheet" href="/views/styles/styles.css">
    <link rel="stylesheet" href="/views/styles/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js" defer></script>
    <script src="/js/d3.v7.min.js" defer></script>   
    <script type="module" src="/js/graficas.js" defer></script> 
    <script type="module" src="/js/grupos.js" defer></script>
   
</head>
<body>
    <header> 
        <?php require_once ROOT . 'views/templates/header.php'; ?>
    </header>
    <main>
        <div class="menulatdiv">
            <div class="menulat">
                <h3>SELECCION POR AULA</h3>
                <form>
                    <?php foreach ($estancias as $estancia):?>
                        <label for="<?php echo $estancia['COD_EST']; ?>"><?php echo $estancia['COD_EST']; ?></label>
                        <input type="checkbox" id="<?php echo $estancia['COD_EST']; ?>" class="est" name="est" value="<?php echo $estancia['COD_EST']; ?>"><br>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
        
        <div class="container">
        <div class="contenido">
            <h1>BIENVENIDO <?php echo $ver['NOMBRE'];?></h1>
            <p>Bienvenido a tu perfil, aquí podrás tener una vista exclusiva a las aulas guardadas en tus grupos así como la opción de crear nuevos</p>
            <p></p>
          

            <ul id="menu">
                <li> <p>TUS GRUPOS</p>
                    <ul id="submenu">
                    <?php foreach ($grupos as $grupo): ?>
                    
                        <li><a class="datus"  value="<?php echo $grupo['NOM_GRUPO'];?>"><?php echo $grupo['NOM_GRUPO'];?></a></li><br>
                    
                    <?php endforeach; ?>
                    </ul>
                </li>
                <li>
                    <a  data-bs-toggle="modal" data-bs-target="#nuevoModal">NUEVO GRUPO +</a>
                </li>
            </ul>
        </div>
        </div>
    </main>
    <section class="carruseles">
        <div id="carruselCards" class="carousel slide" data-bs-ride="carousel" data-bs-slide="true" data-bs-touch="true">
            <div class="carousel-inner">
                <div class="carousel-item active w-100">
                    <h1 class=" text-center text-light ">Datos de Aula</h1>
             
                    <div id="aulas" class=" w-100 bg-white">

                    </div>
        
                </div>                
            
                <div class="carousel-item w-100">
                    <h1 class=" text-center text-light ">Registro de Temperaturas</h1>
                    <div id="temper" class=" w-100 bg-white">

                    </div>
                </div>                
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
        <?php require_once ROOT . 'views/modales.php'?>
    <footer>
         <?php require_once ROOT . 'views/templates/footer.php'; ?>
    </footer>
</body>
</html>
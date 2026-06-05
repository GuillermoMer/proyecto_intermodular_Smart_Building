<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficas</title>
    
    <link rel="stylesheet" href="/views/styles/styles.css">
    <link rel="stylesheet" href="/views/styles/bootstrap.min.css">
    <script src="/js/bootstrap.bundle.min.js" defer></script>
    <script src="/js/d3.v7.min.js" defer></script>
    <script type="module" src="/js/graficas.js" defer></script>
    <script type="module" src="/js/envios.js" defer></script>

</head>  
<body > 
    <header>
        <?php require_once ROOT . 'views/templates/header.php'; ?>
    </header>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            algo no llega
        </div>
    <?php endif; ?>
    <main>
        <div class="container">
            <div class="contenido">
                <h1>Graficas de Evolucion</h1>
                <p>Dentro de este apartado se pueden ver distintas <strong>gráficas</strong> que muestran información relevante para el usuario</p>
            </div>
        </div>
    </main>
    <section class="carruseles">
        <div id="carruselCards" class="carousel slide" data-bs-ride="carousel" data-bs-slide="true" data-bs-touch="true">
            <div class="carousel-inner">
                <div class="carousel-item active  w-100">
                    <h1 class=" text-center text-light ">Porcentaje de radiadores encendidos</h1>
                    <svg id="encendidos" class=" w-100 bg-white">

                    </svg>
                </div>                
           
                <div class="carousel-item   w-100">
                    <h1 class=" text-center text-light ">Datos de Aula</h1>
                    <select name="datoaula" id="datoaula">
                        <?php foreach ($estancias as $estancia):?>
                            <option value="<?php echo $estancia['COD_EST']; ?>"><?php echo $estancia['COD_EST']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="aulas" class=" w-100 bg-white">

                    </div>
                    <!--CON ESTE BOTÓN AÑADES EL AULA VISUALIZADA AL GRUPO DESEADO O A UNO NUEVO-->
                    <button aria-label="añadir estancia a grupo" class="delivery" data-bs-toggle="modal" data-bs-target="#deliveryModal">AÑADIR A GRUPO</button>
                </div>                
            
                <div class="carousel-item   w-100">
                    <h1 class=" text-center text-light ">Registro de Temperaturas</h1>
                    <select name="tempeaula" id="tempeaula">
                        <?php foreach ($estancias as $estancia):?>
                            <option value="<?php echo $estancia['COD_EST']; ?>"><?php echo $estancia['COD_EST']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="tempercont">
                        <svg id="temper" class=" w-100 bg-white">

                        </svg>   
                    </div>
                  
                    <!--CON ESTE BOTÓN AÑADES EL AULA VISUALIZADA AL GRUPO DESEADO O A UNO NUEVO-->
                    <button aria-label="añadir estancia a grupo" class="delivery" data-bs-toggle="modal" data-bs-target="#deliveryModal">AÑADIR A GRUPO</button>
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
    
<div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliveryModalLabel">SELECCIONA GRUPO</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="addtoGrupo">
                    <ul id="menu">
                        <li> <p>TUS GRUPOS</p>
                            <ul id="submenu">
                            <?php foreach ($grupos as $grupo): ?>
                            <li>
                                <a data-id="<?php echo $grupo['NOM_GRUPO'];?>" class="enviar" href="/index.php?action=addtoGrupo&grupo=<?=$grupo['NOM_GRUPO'];?>">
                                    <?php echo $grupo['NOM_GRUPO'];?>
                                </a><br>
                            </li>
                            
                            <?php endforeach; ?>
                            </ul>
                        </li>
                        <li>
                            <a  data-bs-toggle="modal" data-bs-target="#nuevoModal">NUEVO GRUPO +</a>
                        </li>
                    </ul>
                </div>    
            </form>
        </div>
    </div>            
</div> 
    <?php require_once ROOT . 'views/modales.php'?>
    <footer>
         <?php require_once ROOT . 'views/templates/footer.php'; ?>
    </footer>
</body>
</html>
<?php
    require_once ROOT . 'class/user.php';
    require_once ROOT . 'model/modelGrafics.php';
    require_once ROOT . 'controller/controller_graficos.php';
    class ApiController{

        public function extraerApi(){
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = trim($uri, '/');
            $partes = explode("/", $uri);
            return $partes;

        }  
        
        public function grupo($nomgrupo){
            $grupoModel= new GrupoModel();
            $mail= new GraficosController(); 
            $obtener= $grupoModel->aulasGrupo($nomgrupo ,$mail->usuarioActual()->getMail());
            header("Content-Type: application/json");
            echo json_encode($obtener, JSON_PRETTY_PRINT);

        }

        //FUNCIONES PARA GRAFICA RADIADORES 
        public function radiadores(){
            $graficsModel= new GraficModel();
            $resultado = $graficsModel->radiadores(); 
            header("Content-Type: application/json");
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        }
        public function estValvula(){
            $graficsModel= new GraficModel();
            $resultado = $graficsModel->valv();  
            header("Content-Type: application/json");
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        }

        //FUNCIONES PARA GRAFICA AULAS

        public function datosAula($aula){
            $graficsModel= new GraficModel();
            $resultado = $graficsModel->tempAula($aula);
            header("Content-Type: application/json");
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        }

        public function verCaldera(){
            $graficsModel= new GraficModel();
            $resultado = $graficsModel->verCaldera();
            header("Content-Type: application/json");
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        }

        public function vertemp(){
            $graficsModel= new GraficModel();
            $tempes=$graficsModel->verTempe();
            header("Content-Type: application/json");
            echo json_encode($tempes, JSON_PRETTY_PRINT);
        }



        public function graficaTemperaturas($aula){
            $graficsModel= new GraficModel();
            $resultado = $graficsModel->graficaTemperatura($aula);
            header("Content-Type: application/json");
            echo json_encode($resultado, JSON_PRETTY_PRINT);
        }


        
    }

?> 

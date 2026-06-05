 import{datosAula, tempeAulas} from './graficas.js';
 

 //recoge los grupos existentes y les agrega listeners

 const datoss = document.getElementsByClassName("datus");

 for(let dato of datoss ){
    dato.addEventListener("click", (chase)=> {
        /*cuando se hace click a un grupo limpia la clase "fue" (auxiliar) 
         y se reinicia el listado de nuevas() */
        for (let d of datoss) d.classList.remove('fue');
         const estancias = document.getElementsByClassName("est");
         for(let estancia of estancias )estancia.classList.remove('seleccionado');
         //añade la clase auxiliar al grupo que activó el evento y pasa su contenido como parametro
        chase.target.classList.add('fue');
        datos(chase.target.textContent);        
    });
 }



async function datos(grupos) {
    //llama a grupo con el parametro recibido
    const response = await fetch('index.php/ss/grupo/'+grupos);
    const data = await response.json();
    let pe=[];
    data.forEach((val, index) => {
        pe[index]=val.COD_EST;
        //guarda las aulas correspondientes en un array
    });
    console.log(grupos);
    //pasa como parametro el array a la funcion que genera la grafica
    pe.forEach((val) => {
    datosAula(val);
    
    });
    tempeAulas(pe);
}





//recupera las aulas disponibles
 const estancias = document.getElementsByClassName("est");

 for(let estancia of estancias ){
    //les agrega listeners
    estancia.addEventListener("click", (chase)=> {
        //con toggle se actualiza las clases con cada click llamando a la funcion
        chase.target.classList.toggle('seleccionado');
        nuevas();
    });

 }

 async function nuevas() {
    //cada vez que es llamada recupera todas las seleccionadas
    let todas= document.getElementsByClassName('seleccionado');
    
        let listado=[];
        for(let una of todas){
            listado.push(una.value);
        }
        //guarda su valor en un array 
        console.log(listado);
        //lo envia como parametro sobreescribiendo valores anteriores
        listado.forEach((val) => {
        datosAula(val);
        
        });
        tempeAulas(listado);

 }



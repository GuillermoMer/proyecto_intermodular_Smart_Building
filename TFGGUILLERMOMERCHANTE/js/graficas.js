import * as d3 from 'https://cdn.jsdelivr.net/npm/d3@7/+esm';


const svg = d3.select("#encendidos");
if(!svg){
    console.log("no habemus");
}else{
    graficaRad();
}

async function graficaRad() {
    try {
        const width = 1200;
        const height = 500; 
        const marginTop = 30;
        const marginRight = 0;
        const marginBottom = 30;
        const marginLeft = 40;

        //LLAMADA A CONSEGUIR EL TOTAL DE RADIADORES
        const responser = await fetch('index.php/ss/radiadores');
        const datar = await responser.json();   

        //LLAMADA A CONSEGUIR DATOS DE LA VALVULA
        const response= await fetch('index.php/ss/estValvula');
        const data= await response.json();

        //SE RECUPERAN Y SUMAN TODOS LOS RADIADORES
        let total=0;
        datar.forEach(dr=>{
            total+=parseInt(dr.N_RAD);    
        });
        
        /*SE USA UN SIMPLE CONTROL PARA DELIMITAR LA CANTIDAD DE RADIADORES
        CUANDO UN AULA SE ENCIENDE SUS RADIADORES SE SUMAN Y CUANDO SE APAGA SE RESTAN
        ESTE VALOR SE COMPARA CON EL TOTAL OBTENIDO ANTES*/
        let cont=0;
        const parseTime= d3.timeParse("%Y-%m-%d %H:%M");
         data.forEach(d => {
            const hora   = String(d.HORA).padStart(2, '0');
            const minuto = String(d.MINUT).padStart(2, '0');
            const stringFecha = `${d.FECHA_INI} ${hora}:${minuto}`;
            d.INTERVALO= parseTime(stringFecha);
            if(d.EST_VALVULA==="O"){
                cont+= parseInt(d.N_RAD);
                
            }else if(d.EST_VALVULA==="C"){
                cont-= parseInt(d.N_RAD);
            }
            d.encendidos=(cont/total)*100;
            d.apagados= ((total-cont)/total)*100;
           
        }); 

      svg
        .attr("width", width)
        .attr("height", height)
        .attr("viewBox", [0, 0, width, height])
        .attr("style", "max-width: 100%; height: auto;");


     const x = d3.scaleTime()
            .domain(d3.extent(data, d => d.INTERVALO))
            .range([marginLeft, width - marginRight]);

      const y = d3.scaleLinear()
        .domain([0,100])
        .range([height - marginBottom, marginTop]);

        const lineaEncendidos = d3.line()
            .x(d => x(d.INTERVALO))
            .y(d=> y(d.encendidos));

        const lineApagados = d3.line()
            .x(d => x(d.INTERVALO))
            .y(d=> y(d.apagados));

        svg.append("path")
            .datum(data)
            .attr("fill", "none")
            .attr("stroke", "#E86B1C")
            .attr("stroke-width", 3)
            .attr("d", lineaEncendidos);


        svg.append("path")
            .datum(data)
            .attr("fill", "none")
            .attr("stroke", "#9A9AA8")
            .attr("stroke-width", 3)
            .attr("d", lineApagados);
        // Eje X
        svg.append("g")
            .attr("transform", `translate(0,${height - marginBottom})`)
            .call(d3.axisBottom(x)
                .tickFormat(d3.timeFormat("%d/%m %H:%M"))
            )
            .selectAll("text")
            .style("text-anchor", "start");

        // Eje Y
        svg.append("g")
            .attr("transform", `translate(${marginLeft},0)`)
            .call(d3.axisLeft(y).tickFormat(d => d + "%"))
            .call(g => g.select(".domain").remove())
            .call(g => g.append("text")
                .attr("x", -marginLeft)
                .attr("y", 15)
                .attr("fill", "currentColor")
                .attr("text-anchor", "start")
                .text("↑ % Radiadores"));

        svg.append("circle").attr("cx", width - 200).attr("cy", 20).attr("r", 6).attr("fill", "#E86B1C");
        svg.append("text").attr("x", width - 190).attr("y", 25).text("Encendidos").style("font-size", "13px");
        
        svg.append("circle").attr("cx", width - 200).attr("cy", 45).attr("r", 6).attr("fill", "#9A9AA8");
        svg.append("text").attr("x", width - 190).attr("y", 50).text("Apagados").style("font-size", "13px");

    return svg.node();

    } catch (err) {
        console.log("Error:", err);
    }
}

graficaRad();




const datoaula= document.getElementById('datoaula');
if(!datoaula){
    console.log("no habemus");
}else{
    datoaula.addEventListener("change", datosAula);
    
}


async function datosAula(val){
    try {
       
        const contenedor = document.getElementById("aulas");
        contenedor.innerHTML = "";
     

        contenedor.style.cssText = `
            width: 1200px !important;
            margin-top: 30px !important;
            margin-right: 0px !important;
            margin-bottom: 30px !important;
            margin-left: 10px !important;
        `;
        let valor='A23'; //valor auxiliar de caracter estetico

        //si se encuentra en perfil usará el valor del parámetro
        //en graficas el que reciba del selector
        if(window.location.href.includes("/index.php?action=grafic")){
            valor=datoaula.value;
        }else if(window.location.href.includes("/index.php?action=perfil")){
            valor=val;
        }
        console.log(window.location.href);

        if (!valor) return; // Si no hay aula seleccionada, paramos

        // Peticiones
        const [resA, resC] = await Promise.all([
            fetch('index.php/tt/datosAula/' + valor),
            fetch('index.php/tt/verCaldera')
        ]);

        const data = await resA.json();
        const dataC = await resC.json();

        // 2. Crear estructura de tabla
        let tabla = document.createElement("table");
        
        tabla.style.cssText = `
            width: 1200px !important;
            height: 500px !important;
            margin-right: 0px !important;

        `;
        /*para reutilizar la funcion su ejecucion depende de la pagina donde esté
        para graficas se regirá por el select de dicha parte y cambiará la vista*/
        if(window.location.href.includes("/index.php?action=grafic")){

            // Cabecera
            let headerRow = tabla.insertRow();
            headerRow.innerHTML = `
                <th>Temp. Real</th>
                <th>Temp. Prog</th>
                <th>Estado Caldera</th>
            `;


            data.forEach((d, index) => {
                let fila = tabla.insertRow();
                
                // Obtenemos el estado de la caldera para este mismo índice
                let estado = dataC[index] ? dataC[index].EST_VALVULA : 'N/A';
                
                fila.innerHTML = `
                    <td>${d.temp_real}º</td>
                    <td>${d.temp_programada}º</td>
                    <td>${estado === 'O' ? 'Encendida' : 'Apagada'}</td>
                `;
            });

            /*en el perfil mostrará el aula correspondiente para mayor claridad */
        }else if(window.location.href.includes("/index.php?action=perfil")){

            // Cabecera
            let headerRow = tabla.insertRow();
            headerRow.innerHTML = `
                <th>Aula Monitorizada</th>
                <th>Temp. Real</th>
                <th>Temp. Prog</th>
                <th>Estado Caldera</th>
            `;


            data.forEach((d, index) => {
                let fila = tabla.insertRow();
                
                // Obtenemos el estado de la caldera para este mismo índice
                let estado = dataC[index] ? dataC[index].EST_VALVULA : 'N/A';
                
                fila.innerHTML = `
                    <td>${d.COD_EST}</td>
                    <td>${d.temp_real}º</td>
                    <td>${d.temp_programada}º</td>
                    <td>${estado === 'O' ? 'Encendida' : 'Apagada'}</td>
                `;
            });
        }

        contenedor.appendChild(tabla);
    } catch (err) {
        console.log("Error:", err);
    }
}
datosAula();
export{datosAula};



const tempeaula= document.getElementById('tempeaula');
if(!tempeaula){
    console.log("no habemus");
}else{
    tempeaula.addEventListener("change", caso);
}


async function tempeAulas(val) {
    const contenedor = document.getElementById("temper");
    contenedor.innerHTML = "";
    for (let valas of val) {
    const svgT = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svgT.setAttribute('class', 'w-100 bg-white');
        contenedor.appendChild(svgT);
        const svg = d3.select(svgT);
        await caso(svg, valas);
     }
}
    
async function caso(svgT, val){
    try {
         if(window.location.href.includes("/index.php?action=grafic")){
            svgT= d3.select("#temper");
            svgT.selectAll('*').remove();

          }
        const width = 1200;
        const height = 500;
        const marginTop = 30;
        const marginRight = 0;
        const marginBottom = 30;
        const marginLeft = 30;
          
        
         let valor='A23'; //valor auxiliar de caracter estetico

          svgT
            .attr("width", width)
            .attr("height", height)
            .attr("viewBox", [0, 0, width, height])
            .attr("style", "max-width: 100%; height: auto;");
        //si se encuentra en perfil usará el valor del parámetro
        //en graficas el que reciba del selector
        if(window.location.href.includes("/index.php?action=grafic")){
            valor=tempeaula.value;
        }else if(window.location.href.includes("/index.php?action=perfil")){
            valor=val;
        }
        console.log(window.location.href);

        if (!valor) return;

        const response= await fetch('index.php/ss/graficaTemperaturas/'+ valor);
        const data= await response.json();

        data.forEach
        const parseTime= d3.timeParse("%Y-%m-%d %H:%M");
         data.forEach(d => {
            const hora   = String(d.HORA).padStart(2, '0');
            const minuto = String(d.MINUT).padStart(2, '0');
            const stringFecha = `${d.FECHA} ${hora}:${minuto}`;
            d.INTERVALO= parseTime(stringFecha);
            d.tempe=parseFloat(d.TEMP_ACT);
        }); 
        //console.log(d.tempe);

        const x = d3.scaleTime()
            .domain(d3.extent(data, d => d.INTERVALO))
            .range([marginLeft, width - marginRight]);

      const y = d3.scaleLinear()
        .domain([10,30])
        .range([height - marginBottom, marginTop]);

        const temperaturas = d3.line()
            .x(d => x(d.INTERVALO))
            .y(d=> y(d.tempe));

        svgT.append("path")
            .datum(data)
            .attr("fill", "none")
            .attr("stroke", "#E86B1C")
            .attr("stroke-width", 3)
            .attr("d", temperaturas);

        svgT.append("g")
            .attr("transform", `translate(0,${height - marginBottom})`)
            .call(d3.axisBottom(x)
                .tickFormat(d3.timeFormat("%d/%m %H:%M"))
            )
            .selectAll("text")
            .style("text-anchor", "start");

        // Eje Y
        svgT.append("g")
            .attr("transform", `translate(${marginLeft},0)`)
            .call(d3.axisLeft(y).tickFormat(d => d))
            .call(g => g.select(".domain").remove())
            .call(g => g.append("text")
                .attr("x", -marginLeft)
                .attr("y", 15)
                .attr("fill", "currentColor")
                .attr("text-anchor", "start")
                .text(valor));

        svgT.append("circle").attr("cx", width - 200).attr("cy", 20).attr("r", 6).attr("fill", "#E86B1C");
        svgT.append("text").attr("x", width - 190).attr("y", 25).text("temperaturas").style("font-size", "13px");
        
        return svgT.node();
    } catch (error) {
        console.log("ERROR:", error);
    }
}
tempeAulas();
caso();
export{tempeAulas};


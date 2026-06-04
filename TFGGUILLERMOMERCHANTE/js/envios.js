const envios = document.getElementsByClassName('enviar');
const datoaula = document.getElementById('datoaula');
const tempeaula= document.getElementById('tempeaula');

datoaula.addEventListener("change", () => {
  tempeaula.value = datoaula.value;
    const mandando = document.querySelector('.enviar.manda');
    if (!mandando) {
        console.warn("No hay grupo seleccionado");
        return;
    }
    enviar(mandando.getAttribute('data-id'), datoaula.value);
});

tempeaula.addEventListener("change", () => {
  datoaula.value = tempeaula.value; //iguala los valores para mantener integridad
    const mandando = document.querySelector('.enviar.manda');
    if (!mandando) {
        console.warn("No hay grupo seleccionado");
        return;
    }
    enviar(mandando.getAttribute('data-id'), tempeaula.value);
});
for (let envio of envios) {
    envio.addEventListener("click", (chase) => {
        for (let d of envios) d.classList.remove('manda'); 
        chase.currentTarget.classList.add('manda');
        let group = chase.currentTarget.getAttribute('data-id');
        console.log(group);
        const valor = datoaula.value || tempeaula.value; //obtiene el valor del ultimo input evitando problemas con el default
        enviar(group, valor);
    });
}



async function enviar(group, valor) {
  
    if (!valor) {
        console.warn("No hay valor seleccionado");
        return;
    }

    if (!group) {
        console.warn("No hay grupo seleccionado");
        return;
    }

    console.log("Enviando:", valor, group);

    const formData = new FormData();
    formData.append('aula', valor);
    formData.append('action', 'addtoGrupo');

    const response = await fetch(`/TFGGUILLERMOMERCHANTE/index.php?grupo=${group}`, {
        method: 'POST',
        body: formData
    });

    console.log('Status:', response.status);
}
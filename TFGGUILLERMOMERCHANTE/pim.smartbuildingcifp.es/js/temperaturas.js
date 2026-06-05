      
async function ver(){
    try {
        const response= await fetch('index.php/tt/vertemp');
        const data= await response.json();
        const contenedor = document.getElementById("carruselCards");


        let items = "";
       
        data.forEach((d, index) => {
            const activeClass = index === 0 ? "active" : "";
            items += `
                <div class='carousel-item ${activeClass} w-100'>
                    <h1 class='text-center text-light'>Temperatura en: ${d.COD_EST}</h1>
                    <table class='datos'>
                        <tr><td>${d.TEMP_ACT}º</td></tr>
                    </table>
                </div>
            `;
        });

 
        contenedor.innerHTML = `<div class='carousel-inner'>${items}</div>`;
    } catch (err) {
        console.log("Error:", err);
    }
}
ver();

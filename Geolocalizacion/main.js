const coordenadas= document.getElementById("parrafo")
const enlace= document.getElementById("enlace")

const obtener=()=> {
    //Verificamos que el navegador tenga soporte para geolocalizacion
    if(navigator.geolocation){
        coordenadas.innerText="Localizando..."
        navigator.geolocation.getCurrentPosition(
            (position)=>{
                const longitud = position.coords.longitude
                const latitud = position.coords.latitude

                //coordenadas.innerText="Latitud" +" latitud}, longitud"
                coordenadas.innerText = `Latitud: ${latitud}, Longitud: ${longitud}`;
                enlace.href="https://www.google.com/maps?q=" + latitud + "," + longitud
                enlace.style.display="block"
            },
            (error)=>{
                 coordenadas.inertText = "No se ha podido obtener la ubicacion"
            }
        )
    }else{
       
    }
}
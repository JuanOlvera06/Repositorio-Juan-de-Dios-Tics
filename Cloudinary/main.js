const cloudname="dstrcicli"
const preset = "preset_5C"

const inputf = document.getElementById("fileinput")
const imagen = document.getElementById("imagen")

const subirimg =() => {
    const foto = inputf[0] 
    const formdata = new FormData()
    formdata.append('file', foto)
    formdata.append('upload_preset', preset)

    fetch(`https://api.cloudinary.com/v1_1/${cloudname}/image/upload`, {
        method: 'POST',
        body: formdata
    })

    .then(response => {
        if (!response.ok) throw new Error("Fallo en la comunicación");
        return response.json(); // Convertir respuesta a JSON
    })
    .then(data => {
        alert("¡Subida exitosa!");
        imagen.src=data.secure_url
    })
    .catch(error => {
        // Capturar errores de red o de proceso
        console.error("Error detectado:", error);
    });
}
const coleccion_docentes = [
    {
        nombre: "Luis Alberto",
        apellidos: "Mendoza",
        puesto: "Profesor Investigador",
        edad:41,
        estado: true
    },

    {
        nombre: "Efren",
        apellidos: "Juarez",
        puesto: "Profesor Investigador",
        edad:55,
        estado: false
    },

    {
        nombre: "Hermes",
        apellidos: "Salazar",
        puesto: "Profesor Investigador",
        edad:43,
        estado: true
    }
]

const mostrar=() => {
    //alert(""+coleccion_docentes[0].nombre)
    //recatamos el div que va CONTENER La informacion
    const contenedor= document.getElementById("contenedor")

    //limpiamos el cotenedor
    contenedor.innerHTML=""

    coleccion_docentes.forEach((docente)=>{

        if(docente.estado==true){
    contenedor.innerHTML+="<div class ='tarjeta'>  "+
    "<h2> "+docente.nombre+"</h2> "+" </div>"
    }
    })
}


//instrucciones a fitch

//libreria actions

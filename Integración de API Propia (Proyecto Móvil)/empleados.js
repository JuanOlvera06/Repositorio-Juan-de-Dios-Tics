const urlApi = "https://juandios.grupoctic.com/Peliculas/api/listar.php";

// Función asíncrona para pedir los datos
const cargarEmpleados = () => {
    // Usamos fetch para hacer la petición HTTP
    fetch(urlApi)
        .then(respuesta => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
        .then(data => {
            // La API devuelve un objeto con una propiedad 'items' que contiene el array
            const personajes = data;
           
            console.log("Datos recibidos:", personajes); // Debugging en consola
           
            // Llamamos a la función que se encarga de dibujar en pantalla
            mostrarEmpleados(personajes);
        })
        .catch(error => {
            // Buena práctica: Manejar errores por si falla la red o la API
            console.error("Error al cargar los empleados:", error);
            alert("Hubo un error al cargar los datos. Revisa la consola.");
        })
}

// Función encargada de manipular el DOM
const mostrarEmpleados = (empleados) => {
    // 1. Seleccionamos el contenedor del HTML
    const contenedorEmpleados = document.getElementById("contenedor-empleados");
   
    // 2. Limpiamos el contenedor por si ya tenía contenido previo
    contenedorEmpleados.innerHTML = "";

    // 3. Recorremos cada personaje del array
    empleados.forEach(empleado => {
        // Creamos un elemento DIV nuevo en memoria
        const tarjeta = document.createElement("div");
       
        // Le añadimos la clase CSS que definimos en el paso 3
        tarjeta.classList.add("practice-card");
       
        // Usamos Template Strings (``) para inyectar el HTML interno con los datos
        tarjeta.innerHTML = `
            <img src="${"https://juandios.grupoctic.com/Peliculas/img/"+empleado.foto}" alt="${empleado.Nombre}" width="100%" style="object-fit: contain; height: 300px;">
            <h3 class="practice-title">${empleado.Nombre + " " + empleado.Apellido_Paterno + " " +empleado.Apellido_Materno} </h3>
             <p><strong>Telefono:</strong> ${empleado.Telefono}</p>
            <p><strong>Correo:</strong> ${empleado.Correo}</p>
        `;
       
        // Finalmente, agregamos la tarjeta completa al contenedor principal
        contenedorEmpleados.appendChild(tarjeta);
    })
}
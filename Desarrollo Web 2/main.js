const urlApi = "https://api.disneyapi.dev/character";
const params = new URLSearchParams(window.location.search);
const idPersonaje = params.get("id");

const cargarPersonajes = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApi)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const personajes = data.data;

      console.log("Datos recibidos:", personajes); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrar(personajes);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar los personajes:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

// Función encargada de manipular el DOM
const mostrar = (personajes) => {
  const contenedorper = document.getElementById("contenedor-personajes");

  contenedorper.innerHTML = "";
  

  // Recorremos cada producto
  personajes.forEach((personaje) => {
    const tarjeta = document.createElement("article");

    const clases =
      "bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition";
    tarjeta.classList.add(...clases.split(" "));

    tarjeta.innerHTML = `
    <a href="vistaDetalle.html?id=${personaje._id}">
      <img src="${personaje.imageUrl}" alt="${personaje.name}"
           style="object-fit:contain;height:300px;width:100%;">
             </a>
             <br>
      <h3>${personaje.name}</h3>
    `;

    contenedorper.appendChild(tarjeta);
  });
};




const cargarPersonaje = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApi + "/" + idPersonaje)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const personaje = data;

      console.log("Datos recibidos:", personaje); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrarProducto(personaje);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar los productos:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

const mostrarProducto = (personaje) => {
  const contenedorpersonaje = document.getElementById("contenedor-personaje");
  contenedorpersonaje.innerHTML = "";


  // Recorremos cada producto

  const tarjeta = document.createElement("article");
  

  const clases =
    "bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition w-[85%] md:w-[50%] max-w-4xl mx-auto";
  tarjeta.classList.add(...clases.split(" "));

  tarjeta.innerHTML = `

      <img src="${urlImgApi+personaje.id+".webp"}" alt="${personaje.name}"
           style="object-fit:contain;height:300px;width:100%;">
      <h3>${personaje.name}</h3>
      <p><strong>Edad:</strong> ${personaje.age}</p>
      <p><strong>Ocupacion:</strong>${personaje.occupation}</p>
      <p><strong>Cumpleaños</strong>${personaje.birthdate}</p>
      <p><strong>Genero</strong>${personaje.gender}</p>
        <p><strong>Descripcion</strong>${personaje.description}</p>
      
    `;


  contenedorpersonaje.appendChild(tarjeta);
};




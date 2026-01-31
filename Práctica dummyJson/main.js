const urlApi = "https://dummyjson.com/products";

const cargarProductos = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApi)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const productos = data.products;

      console.log("Datos recibidos:", productos); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrar(productos);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar los productos:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};


// Función encargada de manipular el DOM
const mostrar = (productos) => {
  const contenedorProductos = document.getElementById("contenedor-productos");
  contenedorProductos.innerHTML = "";

  // Recorremos cada producto
  productos.forEach((producto) => {
    const tarjeta = document.createElement("article");

    const clases = "bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition";
    tarjeta.classList.add(...clases.split(" "));

    tarjeta.innerHTML = `
      <img src="${producto.images[0]}" alt="${producto.title}"
           style="object-fit:contain;height:300px;width:100%;">
      <h3>${producto.title}</h3>
      <p><strong>Categoría:</strong> ${producto.category}</p>
      <p><strong>Precio:</strong> $${producto.price}</p>
    `;

    contenedorProductos.appendChild(tarjeta);
  });
};




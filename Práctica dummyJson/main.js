const urlApi = "https://dummyjson.com/products";

const params = new URLSearchParams(window.location.search);
const idProducto = params.get("id");

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

    const clases =
      "bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition";
    tarjeta.classList.add(...clases.split(" "));

    tarjeta.innerHTML = `
    <a href="vistaDetalle.html?id=${producto.id}">
      <img src="${producto.images[0]}" alt="${producto.title}"
           style="object-fit:contain;height:300px;width:100%;">
             </a>
      <h3>${producto.title}</h3>
      <p><strong>Categoría:</strong> ${producto.category}</p>
      <p><strong>Precio:</strong> $${producto.price}</p>
    `;

    contenedorProductos.appendChild(tarjeta);
  });
};


//Funcion al hacer una busqueda una busqueda, para saber que hacer si funciona o de lo contrario falla
const accionBuscar = () => {
  const filtro = document.getElementById("simple-search").value.trim();

  if (filtro === "") {
    cargarProductos(); // si no hay texto, muestra todo
  } else {
    buscarProductos(filtro); // si hay texto, busca
  }
};


//Funcion que trae los productos pero filtrandolos por la busqueda
const buscarProductos = (texto) => {
  fetch(urlApi+"/"+"search?q="+texto)
    .then(respuesta => respuesta.json())
    .then(data => {
      mostrar(data.products);
    })
    .catch(error => {
      console.error("Error en la búsqueda:", error);
    });
};





const cargarProducto = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApi + "/" + idProducto)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const producto = data;

      console.log("Datos recibidos:", producto); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrarProducto(producto);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar los productos:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

const mostrarProducto = (producto) => {
  const contenedorProducto = document.getElementById("contenedor-producto");
    const contenedorReviews = document.getElementById("contenedor-reviews");
  contenedorProducto.innerHTML = "";
  contenedorReviews.innerHTML = "";   // Limpiar reviews

  // Recorremos cada producto

  const tarjeta = document.createElement("article");
  

  const clases =
    "bg-white rounded-lg shadow-md p-5 hover:shadow-xl transition w-[85%] md:w-[50%] max-w-4xl mx-auto";
  tarjeta.classList.add(...clases.split(" "));

  tarjeta.innerHTML = `

      <img src="${producto.images[0]}" alt="${producto.title}"
           style="object-fit:contain;height:300px;width:100%;">
      <h3>${producto.title}</h3>
      <p><strong>Categoría:</strong> ${producto.category}</p>
      <p><strong>Precio:</strong> $${producto.price}</p>
    `;

    
  producto.reviews.forEach((review) => {
      contenedorReviews.innerHTML +=
        '<div class="post">' +
          '<div class="post-title"> <strong>Comenatrio: </strong> ' +
          review.comment +
          '</div>' +
          '<p><strong>ReviewName: </strong>'+ review.reviewerName+'</p>'+
          '<p><strong>Rating: </strong>'+ review.rating+'</p>'
        '</div>';
    });

  contenedorProducto.appendChild(tarjeta);
};



// ========================================Pendiente==================================
const guardarproducto=()=>{
    //creamos las varioables de los elemntos con los que vamos a interactuar 
    const titulo=document.getElementById("titulo").value
    const precio=parseFloat(document.getElementById("precio").value)
    const categoria=document.getElementById("categorias").value
    const descripcion=document.getElementById("descripcion").value
    const resultado=document.getElementById("mensaje-exito")

    //validamos que los elementos no vengan vacios 
    if(!titulo || !precio || !descripcion){
        alert("Completa los campos obligatorios")
        return
    }

    //creamos el objeto que se va por el body 
    const producto={
        title:titulo,
        price:precio,
        category:categoria,
        description:descripcion,
        thumbnail:'https://dummyjson.com/image/400x200/008080/ffffff?text='+titulo
    }

    //hacemos la peticion fetch con el metodo post
    fetch("https://dummyjson.com/products/add",{
        method:"POST",
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify(producto)
    })
    .then(response=>response.json())
    .then(data=>{
        console.log("Respuesta del API", data)
        resultado.style.display="block"
        resultado.className =
    "mt-4 p-4 rounded-md bg-lime-200 text-lime-800 border border-lime-400";
        resultado.innerHTML=`
        <strong>Producto Agregado correctamente!!!</strong><br>
        Id Asignado : ${data.id}<br>
        Nombre      : ${data.title}<br>
        Precio      : $${data.price}.00  

        `
    })
}



const urlApiC = "https://dummyjson.com/products/category-list";

const cargarCategorias = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApiC)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const categorias = data;

      console.log("Datos recibidos:", categorias); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrarCategorias(categorias);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar las categorias:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

// Función encargada de manipular el DOM
const mostrarCategorias = (categorias) => {
  const select  = document.getElementById("categorias");

  select .innerHTML = "";
  

  // Recorremos cada producto
  categorias.forEach((categoria) => {
    const option = document.createElement("option");
    option.textContent = categoria;
    select.appendChild(option);
  });
};

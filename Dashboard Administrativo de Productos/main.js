const urlApi = "https://dummyjson.com/products";

const params = new URLSearchParams(window.location.search);
const idProducto = params.get("id");

let skipeado = 0;
const limite = 10;
let totalProductos = 0;
let texto="";

let filtro=0;
let categoria="";
// 0 buscado normal o mostrar 1 es por categoria

//paginado
const paginado = (numero) => {
  if (numero === 0) {
    if (skipeado > 0) {
      skipeado -= limite;
      cargarProductos();
    }
  } else {
    skipeado += limite;
    cargarProductos();
  }
};

// cargar productos
const buscarProductos = (texto) => {
  fetch(urlApi + "/" + "search?q=" + texto)
    .then((respuesta) => respuesta.json())
    .then((data) => {
      mostrar(data.products);
    })
    .catch((error) => {
      console.error("Error en la búsqueda:", error);
    });
};

const cargarProductos = () => {
  let urlPro = "https://dummyjson.com/products?limit=10&skip=";
  // Usamos fetch para hacer la petición HTTP
 if(filtro===1){
urlPro ="https://dummyjson.com/products/category/"+categoria+"?limit=10&skip="
 }
 else if(filtro==2){
urlPro = "https://dummyjson.com/products/"+"search?q="+texto+"&limit=10&skip=";
 }

  fetch(urlPro + skipeado)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const productos = data.products;
       totalProductos = data.total;

      if (productos.length === 0) {
        alert("Ya no hay más productos");
        skipeado -= limite; // volvemos a la página anterior
        return;
      }

      console.log("Datos recibidos:", productos); // Debugging en consola
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
  const contenedorProductos = document.getElementById("tabla-productos");
  contenedorProductos.innerHTML = "";
  // Recorremos cada producto
  productos.forEach((producto) => {
    const fila = document.createElement("tr");

    fila.className = "hover:bg-slate-50";

    fila.innerHTML = `
       <td class="p-4 border-b border-slate-200">
      <p class="block text-sm text-slate-800">
        ${producto.title}
      </p>
    </td>

    <td class="p-4 border-b border-slate-200">
      <p class="block text-sm text-slate-800">
        ${producto.category}
      </p>
    </td>

    <td class="p-4 border-b border-slate-200">
      <img
        src="${producto.images[0]}"
        class="w-[50px] h-[50px] object-cover rounded-md"
        alt="${producto.title}"
      >
    </td>

    <td class="p-4 border-b border-slate-200">
      <div class="flex gap-3">
    <a
      href="editar.html?id=${producto.id}"
      class="inline-flex items-center justify-center
             text-white bg-blue-600 hover:bg-blue-700
             px-4 py-2 rounded-lg font-bold">
      Editar
    </a>

    <button
  onclick="borrarProducto(1, this)"
  class="inline-flex items-center justify-center
         text-white bg-red-500 hover:bg-red-700
         px-4 py-2 rounded-lg font-bold">
  Borrar
</button>

  </div>
    </td>
    `;

    contenedorProductos.appendChild(fila);
  });
};

const cargarCategoriasBus = () => {
  // Usamos fetch para hacer la petición HTTP
  fetch(urlApiC)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const categorias = data;

      console.log("Datos recibidos:", categorias); // Debugging en consola

      // Llamamos a la función que se encarga de dibujar en pantalla
      mostrarCategoriasBus(categorias);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar las categorias:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

const mostrarCategoriasBus = (categorias) => {
  const select = document.getElementById("categorias");

  select.innerHTML = "";

  // Recorremos cada producto
  categorias.forEach((categoria) => {
    const option = document.createElement("option");
     option.value = categoria;
    option.textContent = categoria;
    select.appendChild(option);
  });

  select.onchange = () => {
    categoria = select.value;
    filtro=1;
    skipeado = 0;
    cargarProductos(); // 👈 la función que tú quieras
  };
};
// =============================================================================================================================

//Funcion al hacer una busqueda una busqueda, para saber que hacer si funciona o de lo contrario falla
const accionBuscar = () => {
  const filtrador = document.getElementById("simple-search").value.trim();
  texto=filtrador;
  if (filtrador === "") {
    cargarProductos(); // si no hay texto, muestra todo
  } else {
    filtro =2;
   cargarProductos();  // si hay texto, busca
  }
};

//Funcion que trae los productos pero filtrandolos por la busqueda


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
  contenedorReviews.innerHTML = ""; // Limpiar reviews

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
      "</div>" +
      "<p><strong>ReviewName: </strong>" +
      review.reviewerName +
      "</p>" +
      "<p><strong>Rating: </strong>" +
      review.rating +
      "</p>";
    ("</div>");
  });

  contenedorProducto.appendChild(tarjeta);
};

// ========================================Pendiente==================================
const guardarproducto = () => {
  //creamos las varioables de los elemntos con los que vamos a interactuar
  const titulo = document.getElementById("titulo").value;
  const precio = parseFloat(document.getElementById("precio").value);
  const categoria = document.getElementById("categorias").value;
  const descripcion = document.getElementById("descripcion").value;
  const resultado = document.getElementById("mensaje-exito");

  //validamos que los elementos no vengan vacios
  if (!titulo || !precio || !descripcion) {
    alert("Completa los campos obligatorios");
    return;
  }

  //creamos el objeto que se va por el body
  const producto = {
    title: titulo,
    price: precio,
    category: categoria,
    description: descripcion,
    thumbnail:
      "https://dummyjson.com/image/400x200/008080/ffffff?text=" + titulo,
  };

  //hacemos la peticion fetch con el metodo post
  fetch("https://dummyjson.com/products/add", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(producto),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Respuesta del API", data);
      resultado.style.display = "block";
      resultado.className =
        "mt-4 p-4 rounded-md bg-lime-200 text-lime-800 border border-lime-400";
      resultado.innerHTML = `
        <strong>Producto Agregado correctamente!!!</strong><br>
        Id Asignado : ${data.id}<br>
        Nombre      : ${data.title}<br>
        Precio      : $${data.price}.00 
        Categoria   : ${data.category} 

        `;
    });
};

const borrarProducto = (idProducto, boton) => {
  const confirmar = confirm("¿Desea borrar el producto?");
  if (!confirmar) return;

  fetch(`https://dummyjson.com/products/${idProducto}`, {
    method: "DELETE",
  })
    .then(res => res.json())
    .then(data => {
      console.log("Producto eliminado:", data);

      // eliminar fila sin recargar
      const fila = boton.closest("tr");
      fila.remove();
    })
    .catch(error => {
      console.error("Error:", error);
      alert("No se pudo eliminar el producto");
    });
};




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
  const select = document.getElementById("categorias");

  select.innerHTML = "";

  // Recorremos cada producto
  categorias.forEach((categoria) => {
    const option = document.createElement("option");
    option.textContent = categoria;
    select.appendChild(option);
  });
};



const cargarEditarProducto = () => {
    if(!idProducto) return;
    fetch('https://dummyjson.com/products/' + idProducto)
    .then(res => res.json())
    .then(producto => {
        document.getElementById('titulo').value = producto.title || '';
        document.getElementById('precio').value = producto.price || '';
        document.getElementById('descripcion').value = producto.description || '';
        document.getElementById('categorias').value = producto.category || 'smartphones';
        document.getElementById('imagen').value = (producto.images && producto.images[0]) || producto.thumbnail || '';
    })
    .catch(err => console.error('Error al cargar producto', err));
}

const editarProducto = () => {
  const titulo = document.getElementById("titulo").value;
  const precio = parseFloat(document.getElementById("precio").value);
  const categoria = document.getElementById("categorias").value;
  const descripcion = document.getElementById("descripcion").value;
  const imagen = document.getElementById("imagen").value;
  const resultado = document.getElementById("mensaje-exito");

  // Validar campos obligatorios
  if (!titulo || !precio || !descripcion) {
    alert("Completa los campos obligatorios");
    return;
  }

  // Crear objeto con los datos editados
  const productoActualizado = {
    title: titulo,
    price: precio,
    category: categoria,
    description: descripcion
  };
  if (imagen) productoActualizado.thumbnail = imagen;

  // Petición PUT a la API de DummyJSON
  fetch("https://dummyjson.com/products/" + idProducto, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(productoActualizado),
  })
    .then(response => response.json())
    .then((data) => {
      console.log("Respuesta API:", data);

      // Mostrar mensaje igual que guardarproducto
      resultado.style.display = "block";
      resultado.className =
        "mt-4 p-4 rounded-md bg-lime-200 text-lime-800 border border-lime-400";
      resultado.innerHTML = `
        <strong>Producto Actualizado correctamente!!!</strong><br>
        Id Asignado : ${data.id}<br>
        Nombre      : ${data.title}<br>
        Precio      : $${data.price}.00  <br>
        Categoria   : ${data.category}
      `;

      // Opcional: redirigir después de 2 segundos
    
    })
    .catch((error) => {
      console.error("Error al actualizar el producto:", error);
      resultado.style.display = "block";
      resultado.className =
        "mt-4 p-4 rounded-md bg-red-200 text-red-800 border border-red-400";
      resultado.innerHTML = "Error al actualizar el producto.";
    });
};

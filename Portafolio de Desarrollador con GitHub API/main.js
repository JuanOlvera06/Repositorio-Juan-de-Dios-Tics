const urlApi = "https://api.github.com/users/";
const nameusuario= "JuanOLvera06"


const cargarPerfil = () => {
  fetch(urlApi + nameusuario)
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const perfil = data
      console.log("Datos recibidos:", data); // Debugging en consola
      mostrar(perfil);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

// Función encargada de manipular el DOM
const mostrar = (perfil) => {
  const contenedorPerfil = document.getElementById("contenedor-perfil");
  contenedorPerfil.innerHTML = "";
  // Recorremos cada producto
 
    const article = document.createElement("article");

    article.className = "max-w-3xl mx-auto rounded-2xl bg-white p-8 shadow-xl text-gray-900";

    article.innerHTML = `
 <div class="flex gap-8 items-start">
      <img
        src="${perfil.avatar_url}"
        alt="Foto de perfil"
        class="h-40 w-40 rounded-full border-4 border-indigo-800 ring ring-gray-300"
      >

      <div class="space-y-4">
        <header>
          <h2 class="text-sm font-semibold uppercase text-gray-500">Nombre</h2>
          <h1 class="text-2xl font-bold text-indigo-800">${perfil.name ?? "Sin nombre"}</h1>
        </header>

        <section>
          <h2 class="text-sm font-semibold uppercase text-gray-500">Biografía</h2>
          <p>${perfil.bio ?? "Sin biografía"}</p>
        </section>

        <footer>
          <h2 class="text-sm font-semibold uppercase text-gray-500">Ubicación</h2>
          <p>${perfil.location ?? "No especificada"}</p>
        </footer>
      </div>
    </div>

 
    `;

    contenedorPerfil.appendChild(article);
  ;
};


const cargarRepos = () => {
  fetch(urlApi + nameusuario+ "/repos?sort=updated&per_page=6&type=owner&direction=desc")
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const repo = data
      console.log("Datos recibidos:", data); // Debugging en consola
      mostrarRepos(data);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

const mostrarRepos = (repos) => {
  const contenedorRepositorios = document.getElementById("contenedor-repos");

  contenedorRepositorios.innerHTML = "";
  

  // Recorremos cada producto
  repos.forEach((repo) => {
    const card = document.createElement("div");

    const clases =
      "bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition p-5 flex flex-col justify-between";
    card.classList.add(...clases.split(" "));

    card.innerHTML = `
    <!-- Título -->
            <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate">
              ${repo.name}
            </h3>

            <!-- Descripción -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
             ${repo.description}
            </p>

            <!-- Info técnica -->
            <div
              class="flex items-center justify-between text-sm text-gray-500 mb-4">
              <span class="px-2 py-1 bg-gray-100 rounded">  ${repo.language} </span>

              <span> ⭐ ${repo.stargazers_count} · 🍴 ${repo.forks_count} </span>
            </div>

            <!-- Fecha -->
            <p class="text-xs text-gray-400 mb-4">${repo.updated_at}</p>

            <!-- Botones -->
            <div class="flex gap-3">
              <a
                href="${repo.html_url}"
                target="_blank"
                class="flex-1 text-center bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition text-sm">
                Ver GitHub
              </a>
              </div>
    `;

    contenedorRepositorios.appendChild(card);
  });
};


const cargarUsuarios = () => {

  fetch(urlApi + nameusuario+ "/followers?per_page=5")
    .then((respuesta) => respuesta.json()) // Convertimos la respuesta cruda a formato JSON
    .then((data) => {
      // La API devuelve un objeto con una propiedad 'items' que contiene el array
      const repo = data
      console.log("Datos recibidos:", data); // Debugging en consola
      mostrarUsuarios(data);
    })
    .catch((error) => {
      // Buena práctica: Manejar errores por si falla la red o la API
      console.error("Error al cargar:", error);
      alert("Hubo un error al cargar los datos. Revisa la consola.");
    });
};

const mostrarUsuarios = (usuarios) => {
  const contuser = document.getElementById("contenedor-usuarios");

  contuser.innerHTML = "";
  

  // Recorremos cada producto
  usuarios.forEach((usuario) => {
    const card = document.createElement("div");

 
    card.innerHTML = `
          <article 
          class="p-3 flex items-center justify-between border rounded-lg hover:bg-gray-100 transition bg-white shadow-md">
         <header class="flex items-center gap-3">
            <img
              class="rounded-full h-10 w-10"
              src="${usuario.avatar_url}"
              alt="Foto de perfil de Jane Doe" />
            <h2 class="text-sm font-bold text-gray-900">${usuario.login}</h2>
          </header>

          <a
          href="${usuario.html_url}"
            class="h-8 px-3 text-sm font-bold text-blue-500 border border-blue-400 rounded-full hover:bg-blue-100 transition">
            Follow
          </a>
        </article>
          
    `;

    contuser.appendChild(card);
  });
};
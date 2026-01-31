const selectUsuario = document.getElementById("select-usuario");
const muroDiv = document.getElementById("muro");
const avatarImg = document.getElementById("avatar-img");
const nombreHead = document.getElementById("nombre-usuario");

// Cargamos los usuarios en el select
fetch("https://jsonplaceholder.typicode.com/users")
  .then((response) => response.json())
  .then((usuarios) => {
    usuarios.forEach((usuario) => {
      const opcion = `<option value="${usuario.id}">${usuario.name}</option>`;
      selectUsuario.innerHTML += opcion;
    });
  });

const cargarMuro = () => {
  const userId = selectUsuario.value;
  const nombre = selectUsuario.options[selectUsuario.selectedIndex].text;

  nombreHead.textContent = nombre;
  avatarImg.src = "https://api.dicebear.com/9.x/adventurer/svg?seed=" + nombre;
  avatarImg.style.display = "block";

  fetch("https://jsonplaceholder.typicode.com/users/" + userId + "/posts")
    .then((response) => response.json())
    .then((posts) => {
      muroDiv.innerHTML = ""; // limpiar el muro

      posts.forEach((post) => {
        muroDiv.innerHTML +=
          '<div class="post">' +
          '<div class="post-title">' +
          post.title +
          "</div>" +
          "</div>";
      });
    });
};

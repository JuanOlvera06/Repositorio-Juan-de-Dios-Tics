const baseDeDatosCloud = [
  { nombre: "Amazon EC2", tipo: "IaaS", estado: "Activo", costo: 35.0 },
  {
    nombre: "Google Drive Enterprise",
    tipo: "SaaS",
    estado: "Activo",
    costo: 12.5,
  },
  { nombre: "Heroku App Server", tipo: "PaaS", estado: "Inactivo", costo: 0.0 },
  {
    nombre: "Azure Virtual Machines",
    tipo: "IaaS",
    estado: "Activo",
    costo: 40.0,
  },
];


const cargarServicios = () => {
  const contserv = document.getElementById("contenedor-servicios");

  contserv.innerHTML = "";

  baseDeDatosCloud.forEach((datoscloud) => {

        contserv.innerHTML += `
            <div class = "card"> 
            <h3> ${datoscloud.nombre} </h3>
            <p> ${datoscloud.tipo}</p>
            <p class= "${datoscloud.estado === "Activo" ? "activo" : "inactivo"}"> 
            ${datoscloud.estado} </p>
            <p> ${datoscloud.costo}</p> 
            </div> 
        `;    
  });
};

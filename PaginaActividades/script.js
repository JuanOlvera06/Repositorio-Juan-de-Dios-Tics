let mapa;
let marcador;
let rectangulo;

// Escuchar el formulario
document.getElementById("formCoordenadas").addEventListener("submit", (e) => {
  e.preventDefault();

  const lat = parseFloat(document.getElementById("latitud").value);
  const lng = parseFloat(document.getElementById("longitud").value);

  mostrarMapa(lat, lng);
});

// Función flecha para mostrar el mapa
const mostrarMapa = (lat, lng) => {

  // Crear el mapa solo una vez
  if (!mapa) {
    mapa = L.map("mapa").setView([lat, lng], 16);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: "© OpenStreetMap"
    }).addTo(mapa);
  } else {
    mapa.setView([lat, lng], 16);
  }

  // Marcador
  if (marcador) {
    mapa.removeLayer(marcador);
  }

  marcador = L.marker([lat, lng])
    .addTo(mapa)
    .bindPopup("Ubicación ingresada")
    .openPopup();

  // Rectángulo
  if (rectangulo) {
    mapa.removeLayer(rectangulo);
  }

  const offset = 0.001;

  const esquinaNorte = lat + offset;
  const esquinaSur = lat - offset;
  const esquinaEste = lng + offset;
  const esquinaOeste = lng - offset;

  rectangulo = L.rectangle(
    [
      [esquinaSur, esquinaOeste],
      [esquinaNorte, esquinaEste]
    ],
    { color: "blue", weight: 2 }
  ).addTo(mapa);
};
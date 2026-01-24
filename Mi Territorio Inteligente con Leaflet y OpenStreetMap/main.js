let lat = 21.056628;
let long = -98.506308;


if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    (respuesta) => {
      const coordenadas = [lat, long];
      let map = L.map("map").setView(coordenadas, 19);

      L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution:
          '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);

      var polygon = L.polygon([
    [21.056597, -98.506311],
    [21.056631, -98.506276],
    [21.056661, -98.506306],
    [21.056628, -98.506345]
]).addTo(map);

polygon.bindPopup("Esta es la ubicacion de la casa de Juan de Dios Olvera Gomez");

    },
    () => {
      alert("No se ha podido obtener la ubicacion");
    },
  );
} else {
}

let lat;
let long;

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    (respuesta) => {
      lat = respuesta.coords.latitude;
      long = respuesta.coords.longitude;

      const coordenadas = [lat, long];

      let map = L.map("map").setView(coordenadas, 13); //l es una variable del script

      L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);

      let marcador = L.marker(coordenadas).addTo(map);
      marcador.bindPopup('<b>Estoy aqui...</b><br> mis coordenasdas son : <br> latitud'+
        lat+ '<br> longitud' + long
      )
      //alert(lat+" lat " + long + "long")
    },
    () => {},
  );
} else {
}

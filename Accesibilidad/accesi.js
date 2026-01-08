// =============================
//  ESTADO GLOBAL
// =============================
let tamañoLetra      = 100;
let contrasteActivo  = false;
let modoSuave        = false;
let modoDaltonico    = false;
let lecturaActiva    = false;   // para el lector
let utterActual      = null;    // instancia de SpeechSynthesis

// =============================
//  AUMENTAR / DISMINUIR LETRA
// =============================
function aumentarLetra() {
    tamañoLetra += 10;
    if (tamañoLetra > 200) tamañoLetra = 200; // límite superior
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

function disminuirLetra() {
    tamañoLetra -= 10;
    if (tamañoLetra < 50) tamañoLetra = 50; // límite inferior
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

function restaurarLetra() {
    tamañoLetra = 100;
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

// =============================
//  CONTRASTE ALTO
// =============================
function toggleContraste() {
    contrasteActivo = !contrasteActivo;
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

// =============================
//  MODO SUAVE (colores menos saturados)
// =============================
function toggleModoSuave() {
    modoSuave = !modoSuave;
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

// =============================
//  MODO DALTONISMO
// =============================
//parent.toggleModoDaltonico()
function toggleModoDaltonico() {
    modoDaltonico = !modoDaltonico;   
    aplicarEstadoAccesibilidad();
    guardarPreferencias();
}

// =============================
//  LECTOR DE PÁGINA
// =============================
function leerPagina() {
    // Si ya está leyendo, detener
    if (lecturaActiva) {
        if (utterActual) {
            utterActual.onend = null;
        }
        window.speechSynthesis.cancel();
        lecturaActiva = false;
        utterActual = null;
        return;
    }

    // Tomar el texto de la página
    const texto = document.body.innerText || document.body.textContent || "";
    if (!texto.trim()) return;

    // Cancelar cualquier lectura previa
    window.speechSynthesis.cancel();

    utterActual = new SpeechSynthesisUtterance(texto);
    utterActual.lang = "es-MX";
    utterActual.rate = 1;
    utterActual.pitch = 1;

    utterActual.onend = function () {
        lecturaActiva = false;
        utterActual = null;
    };

    lecturaActiva = true;
    window.speechSynthesis.speak(utterActual);
}

// =============================
//  APLICAR ESTADO A LA PÁGINA
// =============================
function aplicarEstadoAccesibilidad() {
    // Tamaño de letra
    document.documentElement.style.fontSize = tamañoLetra + "%";

    // Clases en <body>
    document.body.classList.toggle("alto-contraste", contrasteActivo);
    document.body.classList.toggle("modo-suave",      modoSuave);
    document.body.classList.toggle("modo-daltonico",  modoDaltonico);
}

// =============================
//  GUARDAR / CARGAR PREFERENCIAS
// =============================
function guardarPreferencias() {
    const prefs = {
        tamañoLetra,
        contrasteActivo,
        modoSuave,
        modoDaltonico
    };
    localStorage.setItem("acces_prefs", JSON.stringify(prefs));
}

function cargarPreferencias() {
    const raw = localStorage.getItem("acces_prefs");
    if (!raw) return;

    try {
        const prefs = JSON.parse(raw);
        if (typeof prefs.tamañoLetra === "number") tamañoLetra = prefs.tamañoLetra;
        contrasteActivo = !!prefs.contrasteActivo;
        modoSuave      = !!prefs.modoSuave;
        modoDaltonico  = !!prefs.modoDaltonico;
    } catch (e) {
        console.error("Error al cargar acces_prefs:", e);
    }
}

// =============================
//  INICIALIZAR AL CARGAR LA PÁGINA
// =============================
document.addEventListener("DOMContentLoaded", () => {
    cargarPreferencias();
    aplicarEstadoAccesibilidad();
});

// =============================
//  BOTÓN FLOTANTE abrir cerrar
// =============================
function toggleMenuAccesibilidad() {
    const iframe = document.getElementById("menuAccesibilidad");
    if (!iframe) return;

    const visible = iframe.style.display === "block";
    iframe.style.display = visible ? "none" : "block";
    
}

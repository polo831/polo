// Abrir/cerrar desplegables de las opciones del menú
function toggleMenu(triggerElement) {
    const parentMenu = triggerElement.closest('.menu');
    const dropdown = parentMenu.querySelector('.dropdown');
    
    // Si ya está abierto, lo cierra
    const isOpen = dropdown.classList.contains('down');

    // Cierra todos los demás dropdowns abiertos
    document.querySelectorAll('.dropdown.down').forEach(d => {
        d.classList.remove('down');
        d.closest('.menu').classList.remove('open');
    });

    if (!isOpen) {
        dropdown.classList.add('down');
        parentMenu.classList.add('open');
    }
}

// Abrir/cerrar la barra lateral/menú principal en dispositivos móviles
function toggleMobileNavbar() {
    const contenedor = document.getElementById('contenedorMenu');
    const icon = document.getElementById('hamburger-icon');
    
    contenedor.classList.toggle('active');

    if (contenedor.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-xmark');
    } else {
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-bars');
    }
}

// Cierre automático al hacer clic fuera del menú
window.addEventListener('click', function(e) {
    if (!e.target.closest('.menu') && !e.target.closest('.menu-mobile-header')) {
        document.querySelectorAll('.dropdown.down').forEach(d => {
            d.classList.remove('down');
            d.closest('.menu').classList.remove('open');
        });
    }
});


[...document.querySelectorAll('*')]
  .filter(el => el.getBoundingClientRect().right > document.documentElement.clientWidth)
  .forEach(el => console.log(el.className || el.tagName, Math.round(el.getBoundingClientRect().right)));
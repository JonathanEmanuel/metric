document.addEventListener('DOMContentLoaded', function () {
    let uri = window.location.href.split('/');
    let ruta = uri[uri.length - 1];
    ruta = (ruta == '' || ruta == 'index.php') ? 'index' : ruta;
    let menu = 'menu-' + ruta;

    document.getElementById( menu).classList.add('active')

});
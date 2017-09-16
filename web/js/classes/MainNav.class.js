var MainNav = function()
{
    var content = document.querySelector('#mainNav-content');
    var sidebarBody = document.querySelector('#mainNav-sidebar-body');
    var contentConnexion = document.querySelector('#mainNav-connexion');
    var sidebarFooter = document.querySelector('#mainNav-sidebar-footer');
    var button = document.querySelector('#mainNav-button');
    var overlay = document.querySelector('#mainNav-overlay');
    var activatedClass = 'mainNav-activated';

    sidebarBody.innerHTML = content.innerHTML;
    sidebarFooter.innerHTML = contentConnexion.innerHTML;

    button.addEventListener('click', function(e) {
        e.preventDefault();
        console.log("click");
        $('#mainNav').addClass(activatedClass);
    });

    button.addEventListener('keydown', function(e) {
        if (this.parentNode.classList.contains(activatedClass))
        {
            if (e.repeat === false && e.which === 27)
                this.parentNode.classList.remove(activatedClass);
        }
    });

    overlay.addEventListener('click', function(e) {
        e.preventDefault();

        this.parentNode.classList.remove(activatedClass);
    });
}
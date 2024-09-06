import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.changeQuantity = function(amount) {
    const input = document.getElementById('quantite');
    if (input) {
        const currentValue = parseInt(input.value, 10);
        const newValue = currentValue + amount;
        if (newValue >= 1) {
            input.value = newValue;
            input.setAttribute('value', newValue); 
        }
    }
};

// Ajouter les écouteurs d'événements après le chargement du DOM
document.addEventListener('DOMContentLoaded', () => {
    const minusButton = document.querySelector('.quantity__button[name="minus"]');
    const plusButton = document.querySelector('.quantity__button[name="plus"]');

    if (minusButton) {
        minusButton.addEventListener('click', () => changeQuantity(-1));
    }

    if (plusButton) {
        plusButton.addEventListener('click', () => changeQuantity(1));
    }


    //Navbar
    const navbar = document.getElementById('navbar');
    const logo = document.getElementById('logo');
    const scrollThreshold = 150; // Nombre de pixels à défiler avant de fixer la barre de navigation
    const heightPage = document.documentElement.scrollHeight;
    const tailleMain = document.getElementsByClassName('main')[0].clientHeight;

    window.addEventListener('scroll', function() {
        
        if (window.scrollY > scrollThreshold && tailleMain > 730) {
            navbar.classList.add('navbar-fixed', 'navbar-fixed-shadow');
            logo.className = 'logo-fixed';
        } else {
            navbar.classList.remove('navbar-fixed', 'navbar-fixed-shadow');
            logo.className = 'logo';
        }
    });
});


document.getElementById("BtnPanier").onclick = function() {
    if(document.getElementById("cart-sidebar").className == "open"){

        document.getElementById("cart-sidebar").classList = "close";
    }else{
        document.getElementById("cart-sidebar").className = "open";
    }
}

document.getElementById("close-cart").onclick = function() {
    document.getElementById("cart-sidebar").classList = "close";
}

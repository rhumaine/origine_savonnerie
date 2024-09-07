import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Fonction pour changer la quantité
window.changeQuantity = function(amount) {
    const $input = $('#quantite');
    if ($input.length) {
        const currentValue = parseInt($input.val(), 10);
        const newValue = currentValue + amount;
        if (newValue >= 1) {
            $input.val(newValue);
            $input.attr('value', newValue);
        }
    }
};


$(document).ready(function() {
    const $minusButton = $('.quantity__button[name="minus"]');
    const $plusButton = $('.quantity__button[name="plus"]');

    if ($minusButton.length) {
        $minusButton.on('click', function() {
            changeQuantity(-1);
        });
    }

    if ($plusButton.length) {
        $plusButton.on('click', function() {
            changeQuantity(1);
        });
    }

    // Navbar
    const $navbar = $('#navbar');
    const $logo = $('#logo');
    const scrollThreshold = 150; // Nombre de pixels à défiler avant de fixer la barre de navigation
    const $tailleMain = $('.main').first().outerHeight();

    $(window).on('scroll', function() {
        if ($(window).scrollTop() > scrollThreshold && $tailleMain > 1000) {
            $navbar.addClass('navbar-fixed navbar-fixed-shadow');
            $logo.removeClass('logo').addClass('logo-fixed');
        } else {
            $navbar.removeClass('navbar-fixed navbar-fixed-shadow');
            $logo.removeClass('logo-fixed').addClass('logo');
        }
    });

    // Gestion du panier
    $('#BtnPanier').on('click', function() {
        const $cartSidebar = $('#cart-sidebar');
        if ($cartSidebar.hasClass('open')) {
            $('.overlay').hide();
            $cartSidebar.removeClass('open').addClass('close');
        } else {
            $('.overlay').show();
            $cartSidebar.removeClass('close').addClass('open');
        }
    });

    $('#close-cart').on('click', function() {
        $('.overlay').hide();
        $('#cart-sidebar').removeClass('open').addClass('close');
    });

    $('.overlay').on('click', function() {
        $('.overlay').hide();
        $('#cart-sidebar').removeClass('open').addClass('close');
    });
});

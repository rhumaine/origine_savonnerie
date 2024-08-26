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
});


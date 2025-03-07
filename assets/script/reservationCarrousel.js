// carrousel du Choix d'un cours pour choisir un poney


const carrousel = document.getElementById('carrousel');
let currentIndex = 0;

function scrollCarousel(direction) {
const items = document.querySelectorAll('.poney-item');
const totalItems = items.length;
const itemWidth = items[0].offsetWidth + 20; // Largeur + marge

// Calculer le nouvel index
currentIndex += direction;
if (currentIndex < 0) {
currentIndex = totalItems - 1; // Revenir au dernier élément
} else if (currentIndex >= totalItems) {
currentIndex = 0; // Revenir au premier élément
}

// Scroll
carrousel.scrollTo({
left: currentIndex * itemWidth,
behavior: 'smooth'
});
}

function positionButtons() {
carrousel_container = document.getElementById('carrousel');
button_left = document.getElementById('button-left');
button_right = document.getElementById('button-right');

const middleHeight = carrousel_container.getBoundingClientRect().height / 2;
button_left.style.top = middleHeight + "px";
button_right.style.top = middleHeight + "px";
}

// Appeler la fonction initialement
positionButtons();

// Mettre à jour la position des boutons en cas de redimensionnement
window.addEventListener('resize', positionButtons);

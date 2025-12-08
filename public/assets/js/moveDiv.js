const mobileCanvas = document.querySelector('.mobile-canvas__phone');

// Sélectionne la balise <ul> dans laquelle on veux déplacer la div
const navList = document.querySelector('nav ul'); 

function moveDivOnResize() {
  if (window.innerWidth <= 991) {
    // Si la largeur de l'écran est inférieure ou égale à 991px, déplacer la div à la fin de <ul>
    navList.appendChild(mobileCanvas); // Cela place la div à la fin de <ul>
  } else {
    const originalParent = document.querySelector('.header__container');
    originalParent.appendChild(mobileCanvas); // Remet la div dans son parent original
  }
}

moveDivOnResize();

window.addEventListener('resize', moveDivOnResize);
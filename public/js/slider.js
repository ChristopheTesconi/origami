// Le fichier app.js gère l'application
// Le module app est le module de l'application (des parties JS du site web)
const app = {

    // Méthode d'initialisation de l'application
    init: function() {

        console.log('app.init OK');

        // On va initialiser tous les modules qui doivent être lancés au chargement de la page
        slider.init();
    }
};

// On exécute app.init quand la page est chargée
document.addEventListener('DOMContentLoaded', app.init);

// Pour le slider on veut ajouter des images dans la section.slider

const slider = {
    // propriété (= variable du module) qui mémorise la position
    // de l'image actuellement affichée
    slideNumber: 0,
    // propriété qui mémorise le nombre d'image
    slideImagesNumber: 0,
    init: function() {
        slider.generateSlider();
        // gestion du clic sur les boutons : on attache un écouteur d'événement
        const buttonsElements = document.getElementsByClassName('slider__btn');
        // Bouton précédent
        buttonsElements[0].addEventListener('click', slider.handleClickPrevious);
        // Bouton suivant
        buttonsElements[1].addEventListener('click', slider.handleClickNext);
    },

    // Méthode qui permet de passer à l'image précédente
    handleClickPrevious: function() {
        // on décrémente la position actuelle
        slider.slideNumber--;
        // si slideNumber est < 0 on le passe à nombre d'images - 1 pour afficher la dernière image
        if (slider.slideNumber < 0) {
            slider.slideNumber = slider.slideImagesNumber - 1;
        }
        // on affiche l'image
        slider.goToSlide(slider.slideNumber);
    },

    // Méthode qui permet de passer à l'image suivante
    handleClickNext: function() {
        // quelle est la position actuelle => slider.slideNumber
        // on incrémente la position
        slider.slideNumber++;
        // si slideNumber est plus grand que le nombre d'images, on passe à 0 pour afficher la première image
        if (slider.slideNumber > slider.slideImagesNumber - 1) {
            slider.slideNumber = 0;
        }
        // on affiche l'image à la nouvelle position : goToSlide()
        slider.goToSlide(slider.slideNumber);
    },

    // Méthode qui permet d'afficher une image du slider
    // Paramètre newPosition : numéro de l'image à afficher
    goToSlide: function(newPosition) {       
        // newPosition ne doit pas être inférieur à 0
        // newPosition ne doit pas être plus grand que le nombre d'images
        const sliderImagesElements = document.querySelectorAll('.slider__img');
        if (newPosition >= 0 && newPosition < sliderImagesElements.length) {
            // il faut enlever la classe slider__img--current
            document.querySelector('.slider__img--current').classList.remove('slider__img--current');
            // on ajoute la classe à l'image indiquée par newPosition
            sliderImagesElements[newPosition].classList.add('slider__img--current');
        }
    },
 
        // ...
    
        // Fonction qui génère le slider en récupérant les images depuis le serveur
        generateSlider: function() {
            // Effectue une requête HTTP GET vers l'URL '/images'
            fetch('/', {
                 // Configuration supplémentaire de la requête, notamment les en-têtes
                headers: {
                    // Spécifie l'en-tête 'Accept' pour indiquer le type de contenu attendu dans la réponse
                    'Accept': 'application/json',
                },
            })
                // Attend la réponse et la transforme en JSON
                .then(response => response.json())
                // Traite les données JSON récupérées
                .then(data => {
                    // Récupère la longueur du tableau d'images
                    slider.slideImagesNumber = data.length;
    
                    // Sélectionne le conteneur du slider dans le HTML
                    const sliderContainer = document.querySelector('.slider');
    
                    // Parcourt chaque chemin d'image dans le tableau de données
                    for (const currentImage of data) {
                        // Crée un nouvel élément <img> pour chaque image
                        const newSliderImage = document.createElement('img');
    
                        // Définit l'attribut 'src' de l'image avec le chemin actuel
                        newSliderImage.src = currentImage;
    
                        // Ajoute la classe 'slider__img' à l'élément <img>
                        newSliderImage.classList.add('slider__img');
    
                        // Définit l'attribut 'alt' de l'image
                        newSliderImage.alt = 'Image du slider';
    
                        // Ajoute l'image au début du conteneur avec la méthode 'prepend()'
                        sliderContainer.prepend(newSliderImage);
                    }
    
                    // Sélectionne la première image dans le slider
                    const firstSliderImage = document.querySelector('.slider__img');
    
                    // Si une première image est trouvée, ajoute la classe 'slider__img--current'
                    if (firstSliderImage) {
                        firstSliderImage.classList.add('slider__img--current');
                    }
                });
        },
    
        // ...
    
    };
// Appelle la fonction 'generateSlider()' pour initialiser le slider avec les images
// slider.generateSlider();

setInterval(slider.handleClickNext, 6000);


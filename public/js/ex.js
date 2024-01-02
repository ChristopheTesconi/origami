// ...

const slider = {
    // ...

    // Fonction qui génère le slider en récupérant les images depuis le serveur
    generateSlider: function() {
        // Effectue une requête HTTP GET vers l'URL '/images'
        fetch('/images')
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
slider.generateSlider();

// Définit un intervalle de 6000 millisecondes (6 secondes) pour appeler 'handleClickNext' automatiquement
setInterval(slider.handleClickNext, 6000);


    // Méthode qui génère le slider
    generateSlider: function() {
        // On a un tableau qui liste les images, on va le parcourir
        // pour créer dynamiquement les images et les ajouter
        // au conteneur (au slider)
        const sliderImages = [
            'dragon1.png',
            'cheval.jpeg',
            'grenouille.jpeg',
        ];
        // On définit le nombre d'images
        slider.slideImagesNumber = sliderImages.length;
        // sélection du conteneur de l'image
        const sliderContainer = document.querySelector('.slider');
        for (const currentImage of sliderImages) {
            // On crée un élément image
            const newSliderImage = document.createElement('img');
            // On personnalise l'image
            // - ajout de l'attribut src
            newSliderImage.src = 'image/' +currentImage;
            // - ajout de la classe slider__img
            newSliderImage.classList.add('slider__img');
            // - ajout d'un attribut alt
            newSliderImage.alt = 'Image du slider';
            // - ajout de l'image au début du conteneur avec la méthode prepend()
            sliderContainer.prepend(newSliderImage);
        }
        // on doit ajouter la classe slider__img--current sur la première image
        // - sélection de la première image
        const firstSliderImage = document.querySelector('.slider__img');
        // - ajout de la classe
        firstSliderImage.classList.add('slider__img--current');
    }
}
setInterval(slider.handleClickNext, 6000);
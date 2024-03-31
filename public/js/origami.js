// // Attend que le document soit entièrement chargé avant d'exécuter le code JavaScript
// $(document).ready(function () {

//     // Effectue une requête AJAX pour récupérer la liste des origamis depuis l'API
//     $.ajax({
//         url: '/api/origami',        // L'URL de l'API Origami
//         type: 'GET',                 // Méthode HTTP GET pour récupérer des données
//         dataType: 'json',            // Type de données attendu dans la réponse (JSON)
//         success: function (data) {   // Fonction à exécuter en cas de succès
//             // Appelle la fonction pour afficher les origamis sur la page
//             displayOrigamis(data);
//             //console.log('Données reçues :', data);
//         },
//         error: function (error) {     // Fonction à exécuter en cas d'erreur
//             console.error('Une erreur s\'est produite', error);
//         }
//     });

//     // Fonction pour afficher les origamis sur la page
//     function displayOrigamis(origamis) {
//         var origamiList = $('#origami-list');   // Sélectionne l'élément HTML avec l'ID 'origami-list'

//         // Vide le contenu actuel de la liste d'origamis
//         origamiList.empty();

//         // Parcours chaque origami dans la liste récupérée depuis l'API
//         origamis.forEach(function (origami) {
//             var origamiItemHtml = `
//                 <div class="origami-list">
//                     <h3>${origami.name}</h3>
//                     <img src="${origami.picture}" alt="${origami.name}">
//                     <p>${origami.description}</p>
//                 </div>`;
//             origamiList.append(origamiItemHtml);
//             console.log(origami);
//         });
//     }
// });


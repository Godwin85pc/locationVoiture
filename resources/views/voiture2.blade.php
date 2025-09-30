<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nos Véhicules</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background-color: #f5f5f5; }
    .vehicle-card { margin-bottom: 30px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; transition: transform .2s; }
    .vehicle-card:hover { transform: translateY(-5px); }
    .vehicle-header { display: flex; flex-wrap: wrap; align-items: center; }
    .vehicle-image-container { width: 100%; max-width: 300px; flex-shrink: 0; }
    .vehicle-image { width: 100%; border-radius: 10px; object-fit: cover; }
    .vehicle-info-container { padding-left: 20px; flex: 1; }
    .pack-options { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; }
    .pack-card { flex: 1 1 200px; border: 1px solid #ccc; padding: 15px; border-radius: 10px; background: #f8f9fa; }
    .btn-reserve { background-color: #007bff; color: #fff; }
    .rating { color: #ffc107; }
    .vehicle-details-btn { cursor: pointer; color: #007bff; }
    .search-summary { font-size: 0.95rem; }
    @media(max-width: 768px){
      .vehicle-header { flex-direction: column; }
      .vehicle-info-container { padding-left: 0; margin-top: 15px; }
      .pack-options { flex-direction: column; }
    }
  </style>
</head>
<body>

<!-- Header / Navbar -->
<nav class="navbar navbar-light bg-primary px-3">
  <a class="navbar-brand text-white" href="#">MonSite</a>
  <div class="dropdown ms-auto">
    <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
      <li><a class="dropdown-item" href="{{ route('connection') }}">Se connecter</a></li>
      <li><a class="dropdown-item" href="#">À propos</a></li>
      <li><a class="dropdown-item" href="{{ route('01-ajout_voiture') }}">Louer ma voiture</a></li>
    </ul>
  </div>
</nav>
<style>
  .navbar-toggler { border: none; }
  .navbar-toggler-icon { filter: invert(1); width: 2rem; height: 2rem; }
</style>

<!-- Résumé de la recherche -->
<div class="container mt-4">
  <div class="search-summary bg-white rounded p-4 shadow-sm">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
      <div class="d-flex flex-column flex-sm-row gap-3 flex-wrap">
        <div><strong>Lieu de départ :</strong> <span id="pickup-location"></span></div>
        <div><strong>Lieu de retour :</strong> <span id="return-location"></span></div>
        <div><strong>Date de départ :</strong> <span id="pickup-date"></span></div>
        <div><strong>Date de retour :</strong> <span id="return-date"></span></div>
        <div><strong>Âge du conducteur :</strong> <span id="driver-age"></span></div>
        <div><strong>Véhicules trouvés :</strong> <span id="vehicles-count"></span></div>
      </div>
      <div class="mt-2 mt-sm-0">
        <a href="{{ route('index') }}" class="btn btn-outline-primary">Modifier la recherche</a>
      </div>
    </div>
    <div class="text-end mt-2">
      <label for="sort-options" class="form-label me-2">Trier par :</label>
      <select id="sort-options" class="form-select d-inline-block w-auto">
        <option value="relevance">Pertinence</option>
        <option value="price-asc">Prix croissant</option>
        <option value="price-desc">Prix décroissant</option>
        <option value="category">Catégorie</option>
      </select>
    </div>
  </div>
</div>

<!-- Liste des véhicules -->
<div class="container mt-4">
  <div class="row" id="vehicles-container"></div>
</div>

<!-- Modal détails véhicule -->
<div class="modal fade" id="vehicleDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Détails du véhicule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="vehicleDetailsContent"></div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-auto">
  <div class="container py-4">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>LocationVoiture</h5>
        <p>Le meilleur choix pour votre location de véhicule. Confort, sécurité et prix compétitifs garantis.</p>
        <div class="d-flex">
          <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>Contactez-nous</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue de Paris, France</li>
          <li><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</li>
          <li><i class="fas fa-envelope me-2"></i> info@locationvoiture.fr</li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Newsletter</h5>
        <p>Abonnez-vous pour recevoir nos offres exclusives</p>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Votre email">
          <button class="btn btn-primary">S'abonner</button>
        </div>
      </div>
    </div>
    <hr class="my-4 bg-light">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 LocationVoiture. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a2d0cf4d5e.js" crossorigin="anonymous"></script>
<script>
// ========================
// Données véhicules simulées
// ========================
const vehiclesData = [
  {
    id: 1,
    name: "PEUGEOT 208",
    category: "Citadine",
    condition: "Economique J - 18 ans minimum avec 1 an de permis",
    rating: 7.9,
    transmission: "Automatique",
    hasAirConditioning: true,
    doors: 5,
    seats: 5,
    fuelPolicy: "Plein à rendre plein",
    includedKm: 750,
    features: ["Responsabilité civile","Assurance tous risques","Annulation gratuite"],
    packs: [
      { name: "PACK STANDARD", price: 151, currency: "€", features: ["Responsabilité civile","Assurance tous risques avec franchise"] },
      { name: "PACK PREMIUM", price: 175, currency: "€", features: ["Responsabilité civile","Assurance tous risques","Remboursement des franchises avec Allianz"] }
    ],
    image: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
    reviews: [
      { author: "Jean D.", rating: 4.5, comment: "Très bon véhicule, économique et confortable. Je recommande!", date: "15/09/2025" },
      { author: "Marie L.", rating: 4.0, comment: "Parfait pour la ville, consommation raisonnable.", date: "10/09/2025" }
    ]
  },
  {
    id: 2,
    name: "TOYOTA YARIS CROSS",
    category: "SUV",
    condition: "Compacte L - 21 ans minimum avec 3 ans de permis",
    rating: 8.3,
    transmission: "Automatique",
    hasAirConditioning: true,
    doors: 5,
    seats: 5,
    fuelPolicy: "Plein à rendre plein",
    includedKm: 750,
    features: ["Responsabilité civile","Assurance tous risques","Annulation gratuite"],
    packs: [
      { name: "PACK STANDARD", price: 190, currency: "€", features: ["Responsabilité civile","Assurance tous risques avec franchise"] },
      { name: "PACK PREMIUM", price: 230, currency: "€", features: ["Responsabilité civile","Assurance tous risques","Remboursement des franchises avec Allianz"] }
    ],
    image: "https://images.unsplash.com/photo-1623018035782-b269248df916?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
    reviews: [
      { author: "Pierre M.", rating: 4.8, comment: "Excellente voiture, très spacieuse et confortable pour les longs trajets.", date: "12/09/2025" },
      { author: "Sophie T.", rating: 4.2, comment: "Bon rapport qualité-prix, consommation correcte pour un SUV.", date: "08/09/2025" }
    ]
  }
];

// ========================
// Fonctions JS
// ========================
function getSearchParams() {
  const params = new URLSearchParams(window.location.search);
  return {
    pickupLocation: params.get('pickupLocation') || '',
    returnLocation: params.get('returnLocation') || '',
    pickupDate: params.get('pickupDate') || '',
    returnDate: params.get('returnDate') || '',
    driverAge: params.get('driverAge') || ''
  };
}

function displaySearchParams() {
  const params = getSearchParams();
  document.getElementById('pickup-location').textContent = params.pickupLocation;
  document.getElementById('return-location').textContent = params.returnLocation;
  document.getElementById('pickup-date').textContent = params.pickupDate;
  document.getElementById('return-date').textContent = params.returnDate;
  document.getElementById('driver-age').textContent = params.driverAge;
}

function displayVehicles(vehicles) {
  const container = document.getElementById('vehicles-container');
  const countElement = document.getElementById('vehicles-count');
  countElement.textContent = vehicles.length;
  container.innerHTML = '';
  vehicles.forEach(vehicle => {
    let ratingStars = '';
    for (let i=1;i<=5;i++){
      if(i<=Math.floor(vehicle.rating)) ratingStars += '<i class="fas fa-star rating"></i>';
      else if(i===Math.ceil(vehicle.rating) && !Number.isInteger(vehicle.rating)) ratingStars += '<i class="fas fa-star-half-alt rating"></i>';
      else ratingStars += '<i class="far fa-star rating"></i>';
    }
    const packsHTML = vehicle.packs.map(pack => `
      <div class="pack-card">
        <h5>${pack.name}</h5>
        <div class="pack-price">${pack.price}${pack.currency}</div>
        <div class="pack-features">
          ${pack.features.map(f=>`<p class="mb-1"><i class="fas fa-check text-success"></i> ${f}</p>`).join('')}
        </div>
        <button class="btn btn-reserve mt-2" onclick="reserveVehicle(${vehicle.id}, '${pack.name}')">RÉSERVER</button>
      </div>
    `).join('');
    container.innerHTML += `
      <div class="col-12">
        <div class="card vehicle-card">
          <div class="card-body">
            <div class="vehicle-header">
              <div class="vehicle-image-container">
                <img src="${vehicle.image}" class="vehicle-image" alt="${vehicle.name}">
              </div>
              <div class="vehicle-info-container">
                <h4 class="card-title">${vehicle.name} ou similaire</h4>
                <p class="vehicle-condition">${vehicle.condition}</p>
                <div class="d-flex align-items-center mb-3">
                  <span class="me-2">${ratingStars}</span>
                  <span>${vehicle.rating}/10</span>
                  <span class="vehicle-details-btn ms-2" onclick="showVehicleDetails(${vehicle.id})">● Informations détaillées</span>
                </div>
                <div class="vehicle-specs mb-3">
                  <div class="row">
                    <div class="col-6">
                      <p class="mb-1"><i class="fas fa-cog"></i> ${vehicle.transmission}</p>
                      <p class="mb-1"><i class="fas fa-snowflake"></i> Climatisation</p>
                    </div>
                    <div class="col-6">
                      <p class="mb-1"><i class="fas fa-car"></i> ${vehicle.doors} portes</p>
                      <p class="mb-1"><i class="fas fa-users"></i> ${vehicle.seats} places</p>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <p class="mb-1"><i class="fas fa-road"></i> ${vehicle.includedKm} km inclus</p>
                  <p class="mb-1"><i class="fas fa-gas-pump"></i> ${vehicle.fuelPolicy}</p>
                  ${vehicle.features.map(f=>`<p class="mb-1"><i class="fas fa-check text-success"></i> ${f}</p>`).join('')}
                </div>
              </div>
            </div>
            <div class="pack-options">${packsHTML}</div>
          </div>
        </div>
      </div>
    `;
  });
}

function reserveVehicle(vehicleId, packName){
  // Encode les paramètres pour l'URL
  const url = `/reservation?vehicleId=${vehicleId}&pack=${encodeURIComponent(packName)}`;
  window.location.href = url;
}

// Modal + avis
function showVehicleDetails(vehicleId){
  const vehicle = vehiclesData.find(v=>v.id===vehicleId);
  const modal = new bootstrap.Modal(document.getElementById('vehicleDetailsModal'));
  let ratingStars = '';
  for (let i=1;i<=5;i++){
    if(i<=Math.floor(vehicle.rating)) ratingStars += '<i class="fas fa-star rating"></i>';
    else if(i===Math.ceil(vehicle.rating) && !Number.isInteger(vehicle.rating)) ratingStars += '<i class="fas fa-star-half-alt rating"></i>';
    else ratingStars += '<i class="far fa-star rating"></i>';
  }
  const reviewsHtml = vehicle.reviews.map(r=>`
    <div class="review-item mb-3 p-3 border rounded">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <strong>${r.author}</strong><small class="text-muted">${r.date}</small>
      </div>
      <div class="mb-2">
        ${Array.from({length:5},(_,i)=>`<i class="fas fa-star ${i<Math.floor(r.rating)?'rating':'text-muted'}"></i>`).join('')}
        <span class="ms-2">${r.rating}/5</span>
      </div>
      <p class="mb-0">${r.comment}</p>
    </div>
  `).join('');
  document.getElementById('vehicleDetailsContent').innerHTML = `
    <div class="row">
      <div class="col-md-6">
        <img src="${vehicle.image}" class="img-fluid rounded mb-3" alt="${vehicle.name}">
        <h4>${vehicle.name}</h4>
        <p class="text-muted">${vehicle.condition}</p>
        <div class="d-flex align-items-center mb-3"><span class="me-2">${ratingStars}</span><span>${vehicle.rating}/10</span></div>
        <h5>Caractéristiques</h5>
        <p><i class="fas fa-cog me-2"></i> Transmission: ${vehicle.transmission}</p>
        <p><i class="fas fa-snowflake me-2"></i> Climatisation: ${vehicle.hasAirConditioning?'Oui':'Non'}</p>
        <p><i class="fas fa-car me-2"></i> Portes: ${vehicle.doors}</p>
        <p><i class="fas fa-users me-2"></i> Places: ${vehicle.seats}</p>
        <p><i class="fas fa-road me-2"></i> Kilométrage inclus: ${vehicle.includedKm} km</p>
        <p><i class="fas fa-gas-pump me-2"></i> Politique carburant: ${vehicle.fuelPolicy}</p>
      </div>
      <div class="col-md-6">
        <h5>Avis des clients</h5>
        ${reviewsHtml.length>0?reviewsHtml:'<p>Aucun avis pour le moment.</p>'}
        <div class="add-review mt-4 p-3 border rounded bg-light">
          <h6>Ajouter un avis</h6>
          <form onsubmit="postReview(event, ${vehicle.id})">
            <div class="row g-2">
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Nom" name="firstName" required>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Prénom" name="lastName" required>
              </div>
            </div>
            <div class="mt-2">
              <textarea class="form-control" placeholder="Votre commentaire" name="comment" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Publier</button>
          </form>
        </div>
      </div>
    </div>
  `;
  modal.show();
}

function postReview(event, vehicleId){
  event.preventDefault();
  const form = event.target;
  const name = form.firstName.value + ' ' + form.lastName.value;
  const comment = form.comment.value;
  const vehicle = vehiclesData.find(v=>v.id===vehicleId);
  vehicle.reviews.push({
    author: name,
    rating: 5,
    comment: comment,
    date: new Date().toLocaleDateString('fr-FR')
  });
  showVehicleDetails(vehicleId);
  form.reset();
}

function sortVehicles(criteria){
  let sortedVehicles = [...vehiclesData];
  switch(criteria){
    case 'price-asc': sortedVehicles.sort((a,b)=>Math.min(...a.packs.map(p=>p.price))-Math.min(...b.packs.map(p=>p.price))); break;
    case 'price-desc': sortedVehicles.sort((a,b)=>Math.min(...b.packs.map(p=>p.price))-Math.min(...a.packs.map(p=>p.price))); break;
    case 'category': sortedVehicles.sort((a,b)=>a.category.localeCompare(b.category)); break;
    default: break;
  }
  displayVehicles(sortedVehicles);
}

document.addEventListener('DOMContentLoaded', function(){
  displaySearchParams();
  displayVehicles(vehiclesData);
  document.getElementById('sort-options').addEventListener('change', function(){ sortVehicles(this.value); });
});
</script>

</body>
</html>

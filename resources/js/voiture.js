// Données véhicules simulées
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
        features: [
            "Responsabilité civile",
            "Assurance tous risques",
            "Annulation gratuite"
        ],
        packs: [
            { name: "PACK STANDARD", price: 151, currency: "€", features: ["Responsabilité civile", "Assurance tous risques avec franchise"] },
            { name: "PACK PREMIUM", price: 175, currency: "€", features: ["Responsabilité civile", "Assurance tous risques", "Remboursement des franchises avec Allianz"] }
        ],
        image: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
        reviews: [
            { author: "Jean D.", rating: 4.5, comment: "Très bon véhicule, économique et confortable.", date: "15/09/2025" },
            { author: "Marie L.", rating: 4.0, comment: "Parfait pour la ville, consommation raisonnable.", date: "10/09/2025" }
        ]
    },
    {
        id: 2,
        name: "TOYOTA YARIS CROSS",
        category: "SUV",
        condition: "Compacte L - 21 ans minimum avec 3 ans de permis",
        rating: 7.9,
        transmission: "Automatique",
        hasAirConditioning: true,
        doors: 5,
        seats: 5,
        fuelPolicy: "Plein à rendre plein",
        includedKm: 750,
        features: ["Responsabilité civile", "Assurance tous risques", "Annulation gratuite"],
        packs: [
            { name: "PACK STANDARD", price: 190, currency: "€", features: ["Responsabilité civile", "Assurance tous risques avec franchise"] },
            { name: "PACK PREMIUM", price: 230, currency: "€", features: ["Responsabilité civile", "Assurance tous risques", "Remboursement des franchises avec Allianz"] }
        ],
        image: "https://images.unsplash.com/photo-1623018035782-b269248df916?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60",
        reviews: [
            { author: "Pierre M.", rating: 4.8, comment: "Excellente voiture, très spacieuse et confortable.", date: "12/09/2025" },
            { author: "Sophie T.", rating: 4.2, comment: "Bon rapport qualité-prix, consommation correcte pour un SUV.", date: "08/09/2025" }
        ]
    }
];

// Affichage paramètres recherche
function displaySearchParams() {
    const params = new URLSearchParams(window.location.search);
    document.getElementById('pickup-location').textContent = params.get('pickupLocation') || 'Paris Gare du Nord';
    document.getElementById('return-location').textContent = params.get('returnLocation') || 'Paris Gare du Nord';
    document.getElementById('pickup-date').textContent = (params.get('pickupDate') || '21/09/2025') + ' à 10:00';
    document.getElementById('return-date').textContent = (params.get('returnDate') || '25/09/2025') + ' à 10:00';
    document.getElementById('driver-age').textContent = `Entre ${params.get('driverAge') || '25-30'} ans`;
}

// Affichage véhicules
function displayVehicles(vehicles) {
    const container = document.getElementById('vehicles-container');
    const countElement = document.getElementById('vehicles-count');
    container.innerHTML = '';
    
    if (vehicles.length === 0) {
        container.innerHTML = `<p class="text-center mt-5">Aucun véhicule disponible.</p>`;
        countElement.textContent = '0';
        return;
    }
    
    countElement.textContent = vehicles.length;
    
    vehicles.forEach(v => {
        let stars = '';
        for (let i=1; i<=5; i++) stars += i <= Math.floor(v.rating)? '<i class="fas fa-star rating"></i>' : '<i class="far fa-star rating"></i>';
        
        const card = document.createElement('div');
        card.className = 'card vehicle-card';
        card.innerHTML = `
            <div class="card-body">
                <div class="vehicle-header">
                    <div class="vehicle-image-container">
                        <img src="${v.image}" class="vehicle-image" alt="${v.name}">
                    </div>
                    <div class="vehicle-info-container">
                        <h4>${v.name} ou similaire</h4>
                        <p class="vehicle-condition">${v.condition}</p>
                        <div class="d-flex align-items-center mb-3">
                            <span class="me-2">${stars}</span>
                            <span>${v.rating}/10</span>
                            <span class="vehicle-details-btn ms-2" onclick="showVehicleDetails(${v.id})">● Informations détaillées</span>
                        </div>
                        <div class="vehicle-specs mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <p><i class="fas fa-cog"></i> ${v.transmission}</p>
                                    <p><i class="fas fa-snowflake"></i> Climatisation</p>
                                </div>
                                <div class="col-6">
                                    <p><i class="fas fa-car"></i> ${v.doors} portes</p>
                                    <p><i class="fas fa-users"></i> ${v.seats} places</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <p><i class="fas fa-road"></i> ${v.includedKm} km inclus</p>
                            <p><i class="fas fa-gas-pump"></i> ${v.fuelPolicy}</p>
                            ${v.features.map(f => `<p><i class="fas fa-check text-success"></i> ${f}</p>`).join('')}
                        </div>
                    </div>
                </div>
                <div class="pack-options">
                    ${v.packs.map(p => `
                        <div class="pack-card">
                            <h5>${p.name}</h5>
                            <div class="pack-price">${p.price}${p.currency}</div>
                            ${p.features.map(f => `<p><i class="fas fa-check text-success"></i> ${f}</p>`).join('')}
                            <button class="btn btn-reserve mt-2" onclick="reserveVehicle(${v.id}, '${p.name}')">RÉSERVER</button>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
        container.appendChild(card);
    });
}

// Réserver
function reserveVehicle(vehicleId, packName) {
    const vehicle = vehiclesData.find(v => v.id === vehicleId);
    const pack = vehicle.packs.find(p => p.name === packName);
    alert(`Vous avez sélectionné le ${packName} pour ${vehicle.name} au prix de ${pack.price}${pack.currency}`);
}

// Détails modal
function showVehicleDetails(id) {
    const v = vehiclesData.find(v => v.id === id);
    const modalEl = document.getElementById('vehicleDetailsModal');
    const modal = new bootstrap.Modal(modalEl);
    
    let stars = '';
    for (let i=1;i<=5;i++) stars += i<=Math.floor(v.rating)? '<i class="fas fa-star rating"></i>' : '<i class="far fa-star rating"></i>';
    
    const reviewsHtml = v.reviews.length ? v.reviews.map(r => `
        <div class="review-item mb-2 p-2">
            <div class="d-flex justify-content-between"><strong>${r.author}</strong><small>${r.date}</small></div>
            <div>${Array.from({length:5},(_,i)=> i<Math.floor(r.rating)? '<i class="fas fa-star rating"></i>':'<i class="far fa-star rating"></i>').join('')}</div>
            <p>${r.comment}</p>
        </div>
    `).join('') : '<p>Aucun avis pour le moment.</p>';
    
    modalEl.querySelector('#vehicleDetailsContent').innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <img src="${v.image}" class="img-fluid rounded mb-3">
                <h4>${v.name}</h4>
                <p class="text-muted">${v.condition}</p>
                <div class="d-flex align-items-center mb-3">${stars} ${v.rating}/10</div>
            </div>
            <div class="col-md-6">
                <h5>Avis des clients</h5>
                ${reviewsHtml}
            </div>
        </div>
    `;
    modal.show();
}

// Filtres
function applyFilters() {
    const maxPrice = parseInt(document.getElementById('priceRange').value);
    const categories = {
        'Citadine': document.getElementById('city-car').checked,
        'Compacte': document.getElementById('compact').checked,
        'Berline': document.getElementById('sedan').checked,
        'SUV': document.getElementById('suv').checked,
        'Monospace': document.getElementById('minivan').checked,
        'Utilitaire': document.getElementById('utility').checked
    };
    const transmissions = {
        'Manuelle': document.getElementById('manual').checked,
        'Automatique': document.getElementById('automatic').checked
    };
    const filtered = vehiclesData.filter(v => {
        const minPackPrice = Math.min(...v.packs.map(p=>p.price));
        return minPackPrice <= maxPrice && categories[v.category] && transmissions[v.transmission];
    });
    displayVehicles(filtered);
}

// Tri
function sortVehicles(criteria){
    let sorted = [...vehiclesData];
    switch(criteria){
        case 'price-asc': sorted.sort((a,b)=> Math.min(...a.packs.map(p=>p.price))-Math.min(...b.packs.map(p=>p.price))); break;
        case 'price-desc': sorted.sort((a,b)=> Math.min(...b.packs.map(p=>p.price))-Math.min(...a.packs.map(p=>p.price))); break;
        case 'category': sorted.sort((a,b)=>a.category.localeCompare(b.category)); break;
    }
    displayVehicles(sorted);
}

// Initialisation
document.addEventListener('DOMContentLoaded', ()=>{
    displaySearchParams();
    displayVehicles(vehiclesData);
    document.getElementById('priceRange').addEventListener('input', e=>document.getElementById('max-price').textContent=e.target.value+'€');
    document.getElementById('sort-options').addEventListener('change', e=>sortVehicles(e.target.value));
});

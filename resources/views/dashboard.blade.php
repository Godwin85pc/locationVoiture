@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- SweetAlert2 --}}
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Réservation enregistrée !',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <h2 class="mb-4 text-primary fw-bold">Bienvenue, {{ Auth::user()->name }} !</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- LAYOUT AVEC SIDEBAR VERTICALE --}}
    <div class="row">
        {{-- SIDEBAR NAVIGATION VERTICALE --}}
        <div class="col-lg-3 col-md-4">
            <div class="list-group mb-4" id="dashboardNav" role="tablist">
                <a class="list-group-item list-group-item-action active d-flex align-items-center" 
                   id="offres-tab" data-bs-toggle="list" href="#offres" role="tab" aria-controls="offres">
                    <i class="bi bi-car-front text-success me-3"></i>
                    <div>
                        <div class="fw-bold">Offres disponibles</div>
                        <small class="text-muted">Parcourir les véhicules</small>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" 
                   id="mes-vehicules-tab" data-bs-toggle="list" href="#mes-vehicules" role="tab" aria-controls="mes-vehicules">
                    <i class="bi bi-car-front-fill text-secondary me-3"></i>
                    <div>
                        <div class="fw-bold">Mes véhicules</div>
                        <small class="text-muted">Gérer mes annonces</small>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action d-flex align-items-center" 
                   id="mes-reservations-tab" data-bs-toggle="list" href="#mes-reservations" role="tab" aria-controls="mes-reservations">
                    <i class="bi bi-calendar-check text-info me-3"></i>
                    <div>
                        <div class="fw-bold">Mes réservations</div>
                        <small class="text-muted">Suivre mes demandes</small>
                    </div>
                </a>
            </div>
        </div>

        {{-- CONTENU PRINCIPAL --}}
        <div class="col-lg-9 col-md-8">
            <div class="tab-content" id="dashboardTabsContent">
                
                {{-- ONGLET OFFRES DISPONIBLES --}}
                <div class="tab-pane fade show active" id="offres" role="tabpanel" aria-labelledby="offres-tab">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-success fw-bold mb-0">
                            <i class="bi bi-car-front"></i> Offres disponibles
                        </h4>
                        <span id="badge-offres-count" class="badge bg-success">{{ $vehiculesDisponibles->count() ?? 0 }} véhicule(s)</span>
                    </div>
                    <div id="offres-server-wrapper" class="row g-4">
                        @forelse($vehiculesDisponibles as $vehicule)
                            <div class="col-lg-4 col-md-6">
                                <div class="card shadow-sm h-100 border-0">
                                    <img src="{{ $vehicule->photo ?? 'https://via.placeholder.com/400x200?text=V%C3%A9hicule' }}" 
                                         class="card-img-top img-fluid" 
                                         alt="Image véhicule"
                                         style="object-fit: cover; height: 200px; width: 100%;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-primary fw-bold">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($vehicule->description ?? 'Véhicule disponible à la location', 80) }}</p>
                                        <div class="mt-auto">
                                            <a href="{{ route('reservations.create', $vehicule->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bi bi-calendar-plus"></i> Réserver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12" id="server-empty-offres">
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-info-circle"></i> Aucun véhicule disponible pour le moment.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Conteneur JS pour affichage dynamique des offres -->
                    <div id="offres-disponibles-container" class="row mt-3"></div>
                </div>

                {{-- ONGLET MES VEHICULES PROPOSES --}}
                <div class="tab-pane fade" id="mes-vehicules" role="tabpanel" aria-labelledby="mes-vehicules-tab">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-secondary fw-bold mb-0">
                            <i class="bi bi-car-front-fill"></i> Mes véhicules proposés
                        </h4>
                        <div>
                            <span class="badge bg-secondary me-2">{{ $mesVehicules->count() ?? 0 }} véhicule(s)</span>
                            <a href="{{ route('vehicules.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Proposer un nouveau véhicule
                            </a>
                        </div>
                    </div>
                    <div class="row g-4">
                        @forelse($mesVehicules as $vehicule)
                            <div class="col-lg-4 col-md-6">
                                <div class="card shadow-sm h-100 border-0">
                                    <img src="{{ $vehicule->photo ?? 'https://via.placeholder.com/400x200?text=V%C3%A9hicule' }}" 
                                         class="card-img-top img-fluid" 
                                         alt="Image véhicule"
                                         style="object-fit: cover; height: 200px; width: 100%;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-secondary fw-bold">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($vehicule->description ?? 'Mon véhicule proposé à la location', 80) }}</p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between gap-2">
                                                <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="btn btn-warning btn-sm flex-fill">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </a>
                                                <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" class="flex-fill">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm w-100" onclick="return confirm('Supprimer ce véhicule ?')">
                                                        <i class="bi bi-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="bi bi-exclamation-triangle"></i> Vous n'avez pas encore proposé de véhicule à la location.
                                    <br>
                                    <a href="{{ route('vehicules.create') }}" class="btn btn-success mt-2">
                                        <i class="bi bi-plus-circle"></i> Proposer votre premier véhicule
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ONGLET MES RESERVATIONS --}}
                <div class="tab-pane fade" id="mes-reservations" role="tabpanel" aria-labelledby="mes-reservations-tab">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-info fw-bold mb-0">
                            <i class="bi bi-calendar-check"></i> Mes réservations
                        </h4>
                        <div>
                            <span class="badge bg-info me-2">{{ $mesReservations->count() ?? 0 }} réservation(s)</span>
                            <a href="#formulaire-location" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Nouvelle réservation
                            </a>
                        </div>
                    </div>
                    @if(isset($mesReservations) && $mesReservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Véhicule</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Lieu</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mesReservations as $reservation)
                                    <tr>
                                        <td class="fw-semibold">{{ $reservation->vehicule->marque }} {{ $reservation->vehicule->modele }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $reservation->lieu_recuperation ?? 'Non défini' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $reservation->statut === 'confirmee' ? 'success' : ($reservation->statut === 'en_attente' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($reservation->statut) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-eye"></i> Détails
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="bi bi-calendar-x"></i> Vous n'avez pas encore de réservation.
                            <br>
                            <small class="text-muted">Cliquez sur "Nouvelle réservation" pour commencer !</small>
                            <br>
                            <a href="#formulaire-location" class="btn btn-primary mt-2">
                                <i class="bi bi-calendar-plus"></i> Faire ma première réservation
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- FORMULAIRE DE RESERVATION --}}
    <section id="formulaire-location" class="mt-5">
        <div class="p-4 rounded bg-light w-100 shadow-lg border mx-auto" style="max-width: 600px; background: rgba(255,255,255,0.95);">
            <h4 class="mb-4 text-center text-primary fw-bold">
                <i class="bi bi-calendar-check"></i> Réservez votre véhicule
            </h4>
            <form method="GET" action="{{ route('vehicules.index') }}">
                <div class="mb-4 position-relative">
                    <label class="form-label fw-semibold" for="lieuRecup">
                        <i class="bi bi-geo-alt-fill text-primary"></i> Lieu de récupération :
                    </label>
                    <input type="text" class="form-control form-control-lg" id="lieuRecup" name="lieu_recuperation" placeholder="Entrez le lieu de récupération" autocomplete="off" />
                    <!-- Hidden fields to store selected place coordinates -->
                    <input type="hidden" name="lieu_recuperation_lat" id="lieuRecup_lat" />
                    <input type="hidden" name="lieu_recuperation_lon" id="lieuRecup_lon" />
                    <!-- Suggestions container (populated by JS) -->
                    <div id="lieuRecup_suggestions" class="list-group position-absolute w-100" style="z-index: 2000; display: none;
                                max-height: 240px; overflow-y: auto;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-clock-history text-primary"></i> Sollicitation du véhicule :
                    </label>
                    <div class="row g-2">
                        <div class="col">
                            <input type="date" class="form-control" name="dateDepart" required />
                        </div>
                        <div class="col">
                            <input type="time" class="form-control" name="heureDepart" required />
                        </div>
                    </div>
                </div>
                <div class="mb-4 position-relative">
                    <label class="form-label fw-semibold" for="lieuRetour">
                        <i class="bi bi-geo-alt text-primary"></i> Lieu de retour :
                    </label>
                    <input type="text" class="form-control form-control-lg" id="lieuRetour" name="lieu_retour" placeholder="Entrez le lieu de retour" autocomplete="off" />
                    <input type="hidden" name="lieu_retour_lat" id="lieuRetour_lat" />
                    <input type="hidden" name="lieu_retour_lon" id="lieuRetour_lon" />
                    <div id="lieuRetour_suggestions" class="list-group position-absolute w-100" style="z-index: 2000; display: none; max-height: 240px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-arrow-repeat text-primary"></i> Retour du véhicule :
                    </label>
                    <div class="row g-2">
                        <div class="col">
                            <input type="date" class="form-control" name="dateRetour" required />
                        </div>
                        <div class="col">
                            <input type="time" class="form-control" name="heureRetour" required />
                        </div>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="ageCheck" name="ageCheck" />
                    <label class="form-check-label fw-semibold" for="ageCheck">
                        <i class="bi bi-person-badge text-primary"></i> Conducteur entre 25 et 30 ans
                    </label>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiUrl = "{{ route('offres.disponibles') }}";
    const container = document.getElementById('offres-disponibles-container');

    if (!container) return;

    function renderCard(vehicule) {
        const img = vehicule.image || vehicule.photo || 'https://via.placeholder.com/400x200?text=V%C3%A9hicule';
        const title = vehicule.nom || (vehicule.marque && vehicule.modele ? `${vehicule.marque} ${vehicule.modele}` : (vehicule.marque || 'Véhicule'));
        const transmission = vehicule.transmission ? `<span class="me-2"><i class="bi bi-gear-fill"></i> ${vehicule.transmission}</span>` : '';
        const portes = vehicule.portes ? `<span class="me-2"><i class="bi bi-door-open-fill"></i> ${vehicule.portes} portes</span>` : '';
        const places = vehicule.places ? `<span class="me-2"><i class="bi bi-people-fill"></i> ${vehicule.places} places</span>` : '';
        const carburant = vehicule.carburant ? `<div class="small text-muted"><i class="bi bi-droplet-fill"></i> ${vehicule.carburant}</div>` : '';
        const kilometrage = vehicule.kilometrage ? `<div class="small text-muted">${vehicule.kilometrage} km inclus</div>` : '';
        const note = vehicule.note ? `<div class="small text-warning">★ ${vehicule.note}</div>` : '';
        const packs = (vehicule.packs || []).map(p => `<div class="badge bg-light text-dark me-1">${p.nom} - ${p.prix}€</div>`).join('');
        const options = (vehicule.options || []).map(o => `<li class="small"><i class="bi bi-check2 text-success"></i> ${o}</li>`).join('');

        return `
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <img src="${img}" class="card-img-top" style="height:200px;object-fit:cover;" />
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">${title}</h5>
                        ${note}
                    </div>
                    <p class="text-muted mb-2">${vehicule.etat || ''}</p>
                    <div class="mb-2 small text-muted">${transmission}${portes}${places}</div>
                    ${carburant}
                    ${kilometrage}
                    ${packs ? `<div class="mt-2">${packs}</div>` : ''}
                    ${options ? `<ul class="mt-2 mb-0 ps-3">${options}</ul>` : ''}
                    <div class="mt-auto pt-2">
                        <a href="#" class="btn btn-outline-primary btn-sm w-100">Réserver</a>
                    </div>
                </div>
            </div>
        </div>`;
    }

    fetch(apiUrl, { credentials: 'same-origin' })
        .then(r => {
            if (!r.ok) throw new Error('Network response not ok');
            const ct = r.headers.get('content-type') || '';
            if (!ct.includes('application/json')) throw new Error('Expected JSON response (maybe redirected to login)');
            return r.json();
        })
        .then(data => {
            // data peut être une collection sous forme d'array
            const list = Array.isArray(data) ? data : (data.data || data.value || []);
            const badge = document.getElementById('badge-offres-count');
            const serverWrapper = document.getElementById('offres-server-wrapper');
            const serverEmpty = document.getElementById('server-empty-offres');

            if (list.length === 0) {
                if (badge) badge.textContent = '0 véhicule(s)';
                container.innerHTML = '<div class="col-12"><div class="alert alert-info">Aucune offre disponible.</div></div>';
                // show server empty message if present
                if (serverEmpty) serverEmpty.style.display = '';
                return;
            }

            // hide server-rendered wrapper when using client-side offers
            if (serverWrapper) serverWrapper.style.display = 'none';
            if (serverEmpty) serverEmpty.style.display = 'none';
            if (badge) badge.textContent = `${list.length} véhicule(s)`;
            container.innerHTML = list.map(renderCard).join('');
        })
        .catch(err => {
            console.error(err);
            container.innerHTML = '<div class="col-12"><div class="alert alert-danger">Erreur lors du chargement des offres.</div></div>';
        });

    // --------- Adresse autocomplete (Nominatim) ---------
    // Simple client-only autocomplete using OpenStreetMap Nominatim (no API key)
    function debounce(fn, wait) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function createSuggestionItem(place) {
        const a = document.createElement('button');
        a.type = 'button';
        a.className = 'list-group-item list-group-item-action';
        a.textContent = place.display_name;
        a.dataset.lat = place.lat;
        a.dataset.lon = place.lon;
        return a;
    }

    async function nominatimSearch(q) {
        if (!q || q.length < 3) return [];
        const url = new URL('https://nominatim.openstreetmap.org/search');
        url.searchParams.set('q', q);
        url.searchParams.set('format', 'json');
        url.searchParams.set('addressdetails', '0');
        url.searchParams.set('limit', '8');
        // polite user-agent via referer header isn't available from browser, rely on default
        const res = await fetch(url.toString(), { headers: { 'Accept-Language': 'fr' } });
        if (!res.ok) return [];
        return res.json();
    }

    function hookupInput(inputId, suggestionsId, latId, lonId) {
        const input = document.getElementById(inputId);
        const sugBox = document.getElementById(suggestionsId);
        const latField = document.getElementById(latId);
        const lonField = document.getElementById(lonId);
        if (!input || !sugBox) return;

        let items = [];
        let selectedIndex = -1;

        function clearSuggestions() {
            sugBox.innerHTML = '';
            sugBox.style.display = 'none';
            items = [];
            selectedIndex = -1;
        }

        input.addEventListener('blur', () => {
            // delay hide so click can register
            setTimeout(clearSuggestions, 150);
        });

        input.addEventListener('keydown', (ev) => {
            if (!items.length) return;
            if (ev.key === 'ArrowDown') {
                selectedIndex = Math.min(items.length - 1, selectedIndex + 1);
                items.forEach((it, i) => it.classList.toggle('active', i === selectedIndex));
                ev.preventDefault();
            } else if (ev.key === 'ArrowUp') {
                selectedIndex = Math.max(0, selectedIndex - 1);
                items.forEach((it, i) => it.classList.toggle('active', i === selectedIndex));
                ev.preventDefault();
            } else if (ev.key === 'Enter') {
                ev.preventDefault();
                if (selectedIndex >= 0 && items[selectedIndex]) items[selectedIndex].click();
            } else if (ev.key === 'Escape') {
                clearSuggestions();
            }
        });

        async function onType(ev) {
            const q = input.value.trim();
            if (q.length < 3) { clearSuggestions(); return; }
            try {
                const results = await nominatimSearch(q);
                sugBox.innerHTML = '';
                if (!results || results.length === 0) { clearSuggestions(); return; }
                results.forEach(r => {
                    const item = createSuggestionItem(r);
                    item.addEventListener('click', () => {
                        input.value = r.display_name;
                        if (latField) latField.value = r.lat;
                        if (lonField) lonField.value = r.lon;
                        clearSuggestions();
                    });
                    sugBox.appendChild(item);
                });
                items = Array.from(sugBox.children);
                selectedIndex = -1;
                sugBox.style.display = '';
            } catch (e) {
                console.error('Autocomplete error', e);
                clearSuggestions();
            }
        }

        input.addEventListener('input', debounce(onType, 300));
    }

    // initialize both fields
    hookupInput('lieuRecup', 'lieuRecup_suggestions', 'lieuRecup_lat', 'lieuRecup_lon');
    hookupInput('lieuRetour', 'lieuRetour_suggestions', 'lieuRetour_lat', 'lieuRetour_lon');
});
</script>
@endpush

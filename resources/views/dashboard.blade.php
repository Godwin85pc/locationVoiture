@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 text-primary fw-bold">
        Bienvenue,
        @if(!empty($isAdminPreview))
            {{ optional(Auth::guard('admin')->user())->prenom }} {{ optional(Auth::guard('admin')->user())->nom }} (aperçu admin)
        @else
            {{ Auth::user()->name }}
        @endif
        !
    </h2>

    @if (!empty($isAdminPreview))
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="bi bi-eye me-2"></i>
            <div>
                Mode aperçu admin: vous visualisez le dashboard comme un utilisateur. Certaines actions peuvent être désactivées.
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
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
                        <span class="badge bg-success">{{ $vehiculesDisponibles->count() ?? 0 }} véhicule(s)</span>
                    </div>
                    <div class="row g-4">
                        @forelse($vehiculesDisponibles as $vehicule)
                            <div class="col-lg-4 col-md-6">
                                <div class="card shadow-sm h-100 border-0">
                             <img src="{{ $vehicule->photo_url }}" 
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
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-info-circle"></i> Aucun véhicule disponible pour le moment.
                                </div>
                            </div>
                        @endforelse
                    </div>
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
                             <img src="{{ $vehicule->photo_url }}" 
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
            <form method="POST" action="{{ route('recapitulatif') }}" id="search-form">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="lieuRecup">
                        <i class="bi bi-geo-alt-fill text-primary"></i> Lieu de récupération :
                    </label>
                    <input type="text" class="form-control form-control-lg" id="lieuRecup" name="lieu_recuperation" placeholder="Entrez le lieu de récupération" required />

                    <!-- Localisation précise (désactivée) -->
                    <!--
                    <input type="hidden" name="lieu_recuperation_lat" id="lieuRecup_lat" />
                    <input type="hidden" name="lieu_recuperation_lon" id="lieuRecup_lon" />
                    <div id="lieuRecup_suggestions" class="list-group position-absolute w-100" style="z-index: 2000; display: none; max-height: 240px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.08);"></div>
                    -->
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-clock-history text-primary"></i> Sollicitation du véhicule :
                    </label>
                    <div class="row g-2">
                        <div class="col">
                            <input type="date" class="form-control" name="dateDepart" id="dateDepart" required />
                        </div>
                        <div class="col">
                            <input type="time" class="form-control" name="heureDepart" id="heureDepart" required />
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" for="lieuRetour">
                        <i class="bi bi-geo-alt text-primary"></i> Lieu de retour :
                    </label>
                    <input type="text" class="form-control form-control-lg" id="lieuRetour" name="lieu_restitution" placeholder="Entrez le lieu de retour" required />

                    <!-- Localisation précise (désactivée) -->
                    <!--
                    <input type="hidden" name="lieu_restitution_lat" id="lieuRetour_lat" />
                    <input type="hidden" name="lieu_restitution_lon" id="lieuRetour_lon" />
                    <div id="lieuRetour_suggestions" class="list-group position-absolute w-100" style="z-index: 2000; display: none; max-height: 240px; overflow-y: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.08);"></div>
                    -->
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-arrow-repeat text-primary"></i> Retour du véhicule :
                    </label>
                    <div class="row g-2">
                        <div class="col">
                            <input type="date" class="form-control" name="dateRetour" id="dateRetour" required />
                        </div>
                        <div class="col">
                            <input type="time" class="form-control" name="heureRetour" id="heureRetour" required />
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
    (function(){
        const dateDepart = document.getElementById('dateDepart');
        const heureDepart = document.getElementById('heureDepart');
        const dateRetour = document.getElementById('dateRetour');
        const heureRetour = document.getElementById('heureRetour');
        const form = document.getElementById('search-form');

        function setReturnMin(){
            if(dateDepart && dateDepart.value){
                // la date de retour ne peut pas être avant la date de départ
                dateRetour.min = dateDepart.value;
                if(dateRetour.value && dateRetour.value < dateDepart.value){
                    dateRetour.value = dateDepart.value;
                }
            }
        }

        dateDepart && dateDepart.addEventListener('change', setReturnMin);
        document.addEventListener('DOMContentLoaded', setReturnMin);

        form && form.addEventListener('submit', function(e){
            if(dateDepart && dateRetour){
                const start = new Date(dateDepart.value + 'T' + (heureDepart?.value || '00:00'));
                const end = new Date(dateRetour.value + 'T' + (heureRetour?.value || '00:00'));
                if(end <= start){
                    e.preventDefault();
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-danger alert-dismissible fade show';
                    alert.role = 'alert';
                    alert.innerHTML = `La date/heure de retour doit être postérieure à la date/heure de récupération.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
                    form.parentElement.prepend(alert);
                    // Caler la date de retour sur la date de départ
                    dateRetour.value = dateDepart.value;
                }
            }
        });

        // Auto-hide flash alerts after 4s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                if(a.classList.contains('show')){
                    a.classList.remove('show');
                }
            });
        }, 4000);

        // ---------- Localisation précise via Nominatim (désactivée) ----------
        // Le code ci-dessous active l'autocomplétion d'adresses et remplit les champs lat/lon.
        // Pour l'activer, décommentez ce bloc ainsi que les champs HTML correspondants.
        /*
        function debounce(fn, wait) {
            let t; return function(...args){ clearTimeout(t); t = setTimeout(() => fn.apply(this, args), wait); };
        }
        function createSuggestionItem(place) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'list-group-item list-group-item-action';
            btn.textContent = place.display_name;
            btn.dataset.lat = place.lat;
            btn.dataset.lon = place.lon;
            return btn;
        }
        async function nominatimSearch(q) {
            if (!q || q.length < 3) return [];
            const url = new URL('https://nominatim.openstreetmap.org/search');
            url.searchParams.set('q', q);
            url.searchParams.set('format', 'json');
            url.searchParams.set('addressdetails', '0');
            url.searchParams.set('limit', '8');
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
            let items = []; let selectedIndex = -1;
            function clearSuggestions(){ sugBox.innerHTML=''; sugBox.style.display='none'; items=[]; selectedIndex=-1; }
            input.addEventListener('blur', () => setTimeout(clearSuggestions, 150));
            input.addEventListener('keydown', (ev) => {
                if (!items.length) return;
                if (ev.key === 'ArrowDown') { selectedIndex = Math.min(items.length-1, selectedIndex+1); items.forEach((it,i)=>it.classList.toggle('active', i===selectedIndex)); ev.preventDefault(); }
                else if (ev.key === 'ArrowUp') { selectedIndex = Math.max(0, selectedIndex-1); items.forEach((it,i)=>it.classList.toggle('active', i===selectedIndex)); ev.preventDefault(); }
                else if (ev.key === 'Enter') { ev.preventDefault(); if (selectedIndex>=0 && items[selectedIndex]) items[selectedIndex].click(); }
                else if (ev.key === 'Escape') { clearSuggestions(); }
            });
            async function onType(){
                const q = input.value.trim();
                if (q.length < 3) { clearSuggestions(); return; }
                try {
                    const results = await nominatimSearch(q);
                    sugBox.innerHTML='';
                    if (!results || !results.length) { clearSuggestions(); return; }
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
                    items = Array.from(sugBox.children); selectedIndex = -1; sugBox.style.display='';
                } catch(e){ console.error('Autocomplete error', e); clearSuggestions(); }
            }
            input.addEventListener('input', debounce(onType, 300));
        }
        hookupInput('lieuRecup','lieuRecup_suggestions','lieuRecup_lat','lieuRecup_lon');
        hookupInput('lieuRetour','lieuRetour_suggestions','lieuRetour_lat','lieuRetour_lon');
        */
    })();
</script>
@endpush

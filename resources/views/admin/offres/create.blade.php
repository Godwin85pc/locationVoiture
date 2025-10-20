@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1">
                <i class="bi bi-plus-circle me-2"></i>Nouvelle Offre d'Agence
            </h2>
            <p class="text-muted mb-0">Créer une offre promotionnelle pour un véhicule de l'agence</p>
        </div>
        <a href="{{ route('admin.offres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour aux offres
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6><i class="bi bi-exclamation-triangle me-2"></i>Erreurs de validation :</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.offres.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Informations principales -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Informations de l'offre
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Sélection du véhicule -->
                            <div class="col-12">
                                <label for="vehicule_id" class="form-label fw-bold">
                                    <i class="bi bi-car-front text-danger me-2"></i>Véhicule d'agence
                                </label>
                                <select name="vehicule_id" id="vehicule_id" class="form-select" required>
                                    <option value="">-- Sélectionner un véhicule --</option>
                                    @foreach($vehicules as $vehicule)
                                        <option value="{{ $vehicule->id }}" 
                                                data-prix="{{ $vehicule->prix_par_jour }}"
                                                {{ old('vehicule_id') == $vehicule->id ? 'selected' : '' }}>
                                            {{ $vehicule->marque }} {{ $vehicule->modele }} 
                                            ({{ $vehicule->immatriculation }}) - 
                                            {{ number_format($vehicule->prix_par_jour, 0, ',', ' ') }} FCFA/jour
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Seuls les véhicules d'agence disponibles sont affichés.</div>
                            </div>

                            <!-- Prix par jour -->
                            <div class="col-md-6">
                                <label for="prix_par_jour" class="form-label fw-bold">
                                    <i class="bi bi-currency-exchange text-success me-2"></i>Prix de l'offre (FCFA/jour)
                                </label>
                                <input type="number" name="prix_par_jour" id="prix_par_jour" 
                                       class="form-control" min="0" step="500" 
                                       value="{{ old('prix_par_jour') }}" required>
                                <div class="form-text">Prix promotionnel pour cette offre spéciale.</div>
                            </div>

                            <!-- Réduction -->
                            <div class="col-md-6">
                                <label for="reduction_pourcentage" class="form-label fw-bold">
                                    <i class="bi bi-percent text-warning me-2"></i>Réduction (%)
                                </label>
                                <input type="number" name="reduction_pourcentage" id="reduction_pourcentage" 
                                       class="form-control" min="0" max="100" step="5" 
                                       value="{{ old('reduction_pourcentage', 0) }}">
                                <div class="form-text">Pourcentage de réduction (optionnel).</div>
                            </div>

                            <!-- Période de l'offre -->
                            <div class="col-md-6">
                                <label for="date_debut_offre" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event text-info me-2"></i>Date de début
                                </label>
                                <input type="date" name="date_debut_offre" id="date_debut_offre" 
                                       class="form-control" min="{{ date('Y-m-d') }}" 
                                       value="{{ old('date_debut_offre', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="date_fin_offre" class="form-label fw-bold">
                                    <i class="bi bi-calendar-x text-info me-2"></i>Date de fin
                                </label>
                                <input type="date" name="date_fin_offre" id="date_fin_offre" 
                                       class="form-control" min="{{ date('Y-m-d') }}" 
                                       value="{{ old('date_fin_offre') }}" required>
                            </div>

                            <!-- Description de l'offre -->
                            <div class="col-12">
                                <label for="description_offre" class="form-label fw-bold">
                                    <i class="bi bi-card-text text-primary me-2"></i>Description de l'offre
                                </label>
                                <textarea name="description_offre" id="description_offre" 
                                          class="form-control" rows="4" 
                                          placeholder="Décrivez les avantages et spécificités de cette offre...">{{ old('description_offre') }}</textarea>
                                <div class="form-text">Description attractive pour présenter l'offre aux clients.</div>
                            </div>

                            <!-- Conditions spéciales -->
                            <div class="col-12">
                                <label for="conditions_speciales" class="form-label fw-bold">
                                    <i class="bi bi-exclamation-diamond text-warning me-2"></i>Conditions spéciales
                                </label>
                                <textarea name="conditions_speciales" id="conditions_speciales" 
                                          class="form-control" rows="3" 
                                          placeholder="Conditions particulières, restrictions, ou exigences...">{{ old('conditions_speciales') }}</textarea>
                                <div class="form-text">Conditions et restrictions applicables à cette offre.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar avec aperçu -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-eye me-2"></i>Aperçu de l'offre
                        </h6>
                    </div>
                    <div class="card-body">
                        <div id="preview-content">
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-car-front display-4"></i>
                                <p class="mt-2">Sélectionnez un véhicule pour voir l'aperçu</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-check-circle me-2"></i>Créer l'offre
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vehiculeSelect = document.getElementById('vehicule_id');
    const prixInput = document.getElementById('prix_par_jour');
    const reductionInput = document.getElementById('reduction_pourcentage');
    const previewContent = document.getElementById('preview-content');
    
    function updatePreview() {
        const selectedOption = vehiculeSelect.options[vehiculeSelect.selectedIndex];
        
        if (selectedOption.value) {
            const vehiculeText = selectedOption.text.split(' - ')[0];
            const prixOriginal = selectedOption.dataset.prix;
            const prixOffre = prixInput.value || prixOriginal;
            const reduction = reductionInput.value || 0;
            
            const economie = prixOriginal - prixOffre;
            const economiePercent = ((economie / prixOriginal) * 100).toFixed(1);
            
            previewContent.innerHTML = `
                <div class="text-center">
                    <div class="bg-danger rounded-circle p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-car-front-fill text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <h6 class="fw-bold">${vehiculeText}</h6>
                    <div class="row g-2 mt-3">
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <small class="text-muted">Prix normal</small>
                                <div class="fw-bold text-decoration-line-through">${parseInt(prixOriginal).toLocaleString()} FCFA</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success text-white rounded p-2">
                                <small class="text-white-50">Prix offre</small>
                                <div class="fw-bold">${parseInt(prixOffre).toLocaleString()} FCFA</div>
                            </div>
                        </div>
                    </div>
                    ${economie > 0 ? `
                        <div class="alert alert-success mt-3 py-2">
                            <small><strong>Économie :</strong> ${parseInt(economie).toLocaleString()} FCFA (${economiePercent}%)</small>
                        </div>
                    ` : ''}
                    ${reduction > 0 ? `
                        <div class="badge bg-warning text-dark mt-2">
                            Réduction ${reduction}%
                        </div>
                    ` : ''}
                </div>
            `;
        } else {
            previewContent.innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="bi bi-car-front display-4"></i>
                    <p class="mt-2">Sélectionnez un véhicule pour voir l'aperçu</p>
                </div>
            `;
        }
    }
    
    // Auto-suggestion du prix avec réduction
    vehiculeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value && selectedOption.dataset.prix) {
            const prixOriginal = parseInt(selectedOption.dataset.prix);
            // Suggérer une réduction de 15%
            const prixSuggere = Math.round(prixOriginal * 0.85);
            prixInput.value = prixSuggere;
            reductionInput.value = 15;
        }
        updatePreview();
    });
    
    prixInput.addEventListener('input', updatePreview);
    reductionInput.addEventListener('input', updatePreview);
    
    // Validation des dates
    document.getElementById('date_debut_offre').addEventListener('change', function() {
        const dateDebut = this.value;
        const dateFinInput = document.getElementById('date_fin_offre');
        if (dateDebut) {
            dateFinInput.min = dateDebut;
            if (dateFinInput.value && dateFinInput.value <= dateDebut) {
                const nextDay = new Date(dateDebut);
                nextDay.setDate(nextDay.getDate() + 1);
                dateFinInput.value = nextDay.toISOString().split('T')[0];
            }
        }
    });
});
</script>

<style>
.sticky-top {
    top: 1rem;
}

.card {
    border-radius: 15px;
}

.form-control:focus, .form-select:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}
</style>
@endsection
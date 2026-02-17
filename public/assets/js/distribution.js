// assets/js/distribution.js

document.addEventListener('DOMContentLoaded', function () {
    const villeSelect = document.getElementById('ville');
    const needsSelect = document.getElementById('needs');

    if (!villeSelect || !needsSelect) {
        console.warn("Selecteurs #ville ou #needs introuvables");
        return;
    }

    villeSelect.addEventListener('change', function () {
        const cityId = this.value;

        // Reset le select des besoins
        needsSelect.innerHTML = '<option value="">Chargement...</option>';

        if (cityId === "") {
            needsSelect.innerHTML = '<option value="">-- Choisir d\'abord une ville --</option>';
            return;
        }

        fetch(`/bngrc/needs/by-city/${cityId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                needsSelect.innerHTML = '<option value="">-- Choisir un besoin --</option>';

                if (data.length === 0) {
                    needsSelect.innerHTML += '<option value="">Aucun besoin disponible</option>';
                    return;
                }

                data.forEach(need => {
                    const option = document.createElement('option');
                    option.value = need.id;
                    option.textContent = `${need.article_name} (${need.unit}) - Restant: ${need.remaining_quantity}`;
                    needsSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des besoins:', error);
                needsSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    });
});
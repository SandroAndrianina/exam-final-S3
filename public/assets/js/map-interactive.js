/**
 * Script pour rendre la carte de Madagascar interactive
 * Affiche les données des villes au survol et au clic
 */

// Données des villes (à mettre à jour avec les vraies données de la base)
let cityData = {};

// Charger les données des villes depuis le serveur
async function loadCityData() {
    try {
        const response = await fetch('/bngrc/api/cities-stats');
        if (response.ok) {
            cityData = await response.json();
        }
    } catch (error) {
        console.warn('Impossible de charger les données des villes:', error);
        // Données par défaut pour le développement
        cityData = {
            'Toamasina': {
                needs: 5,
                gifts: 3,
                distributions: 8,
                purchases: 2
            },
            'Toliara': {
                needs: 3,
                gifts: 2,
                distributions: 4,
                purchases: 1
            },
            'Mahajanga': {
                needs: 4,
                gifts: 5,
                distributions: 7,
                purchases: 3
            }
        };
    }
}

// Initialiser la carte interactive
async function initInteractiveMap() {
    console.log('🗺️ Initialisation de la carte interactive...');
    
    const mapContainer = document.querySelector('.map-container');
    if (!mapContainer) {
        console.error('❌ Conteneur .map-container non trouvé');
        return;
    }
    
    console.log('✅ Conteneur trouvé');
    
    // Chercher d'abord un SVG déjà présent
    let svg = mapContainer.querySelector('svg');
    
    // Si pas de SVG, charger depuis l'image
    if (!svg) {
        console.log('🔄 Chargement du SVG depuis le fichier...');
        const imgElement = mapContainer.querySelector('img[src*="madagascar.svg"]');
        
        if (imgElement) {
            const svgUrl = imgElement.getAttribute('src');
            console.log('📥 URL du SVG:', svgUrl);
            
            try {
                // Charger le SVG via fetch
                const response = await fetch(svgUrl);
                const svgText = await response.text();
                
                // Créer un div temporaire pour parser le SVG
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = svgText;
                svg = tempDiv.querySelector('svg');
                
                if (svg) {
                    // Copier les classes de l'image
                    svg.classList.add('img-fluid');
                    
                    // Remplacer l'image par le SVG
                    imgElement.replaceWith(svg);
                    console.log('✅ SVG chargé et remplacé');
                } else {
                    console.error('❌ Impossible de parser le SVG');
                    return;
                }
            } catch (error) {
                console.error('❌ Erreur lors du chargement du SVG:', error);
                return;
            }
        } else {
            console.error('❌ Aucune image SVG trouvée');
            return;
        }
    }
    
    if (!svg) {
        console.error('❌ SVG non trouvé après chargement');
        return;
    }
    
    console.log('✅ SVG trouvé et prêt');
    
    // Créer le tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'map-tooltip';
    document.body.appendChild(tooltip); // Ajouter au body pour éviter les problèmes de position
    
    // Créer le modal
    const modal = createModal();
    document.body.appendChild(modal);
    
    // Sélectionner tous les paths (régions)
    const paths = svg.querySelectorAll('path');
    console.log(`✅ ${paths.length} régions trouvées`);
    
    if (paths.length === 0) {
        console.error('❌ Aucune région (path) trouvée dans le SVG');
        return;
    }
    
    // Noms de régions correspondant aux villes de la base
    const regions = [
        'Diana', 'Sava', 'Sofia', 'Boeny', 'Betsiboka', 'Melaky',
        'Alaotra-Mangoro', 'Atsinanana', 'Analanjirofo', 'Analamanga',
        'Vakinankaratra', 'Bongolava', 'Itasy', 'Menabe', 'Haute Matsiatra',
        'Amoron\'i Mania', 'Vatovavy-Fitovinany', 'Ihorombe', 'Atsimo-Atsinanana',
        'Atsimo-Andrefana', 'Androy', 'Anosy'
    ];
    
    // Ajouter les événements à chaque région
    paths.forEach((path, index) => {
        const regionName = regions[index] || `Région ${index + 1}`;
        path.setAttribute('data-region', regionName);
        path.style.cursor = 'pointer';
        
        // Hover - Afficher le tooltip
        path.addEventListener('mouseenter', (e) => {
            console.log(`👆 Survol: ${regionName}`);
            path.classList.add('pulse');
            path.style.fill = '#667eea';
            path.style.stroke = '#4facfe';
            path.style.strokeWidth = '2.5';
            showTooltip(tooltip, regionName, e);
        });
        
        path.addEventListener('mousemove', (e) => {
            updateTooltipPosition(tooltip, e);
        });
        
        path.addEventListener('mouseleave', (e) => {
            console.log(`👋 Sortie: ${regionName}`);
            path.classList.remove('pulse');
            path.style.fill = '';
            path.style.stroke = '';
            path.style.strokeWidth = '';
            hideTooltip(tooltip);
        });
        
        // Click - Ouvrir le modal avec détails
        path.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            console.log(`🖱️ Clic: ${regionName}`);
            
            // Retirer l'active de tous
            paths.forEach(p => {
                p.classList.remove('active');
                p.style.fill = '';
            });
            
            // Ajouter active au cliqué
            path.classList.add('active');
            path.style.fill = '#2fb9cb';
            path.style.stroke = '#150c89';
            
            showModal(modal, regionName);
        });
    });
    
    // Fermer le modal en cliquant à l'extérieur
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal(modal);
            paths.forEach(p => {
                p.classList.remove('active');
                p.style.fill = '';
                p.style.stroke = '';
            });
        }
    });
    
    console.log('Carte interactive initialisée avec succès');
}

// Créer le modal
function createModal() {
    const modal = document.createElement('div');
    modal.className = 'region-modal';
    modal.innerHTML = `
        <div class="region-modal-content">
            <h3 id="modal-region-name"></h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <h5>Besoins</h5>
                    <p id="modal-needs">-</p>
                </div>
                <div class="stat-box" style="border-left-color: #f093fb;">
                    <h5>Dons</h5>
                    <p id="modal-gifts">-</p>
                </div>
                <div class="stat-box" style="border-left-color: #fa709a;">
                    <h5>Distributions</h5>
                    <p id="modal-distributions">-</p>
                </div>
                <div class="stat-box" style="border-left-color: #11998e;">
                    <h5>Achats</h5>
                    <p id="modal-purchases">-</p>
                </div>
            </div>
            <button class="close-btn" onclick="document.querySelector('.region-modal').classList.remove('show')">
                Fermer
            </button>
        </div>
    `;
    return modal;
}

// Afficher le tooltip
function showTooltip(tooltip, region, event) {
    const data = cityData[region] || { needs: 0, gifts: 0, distributions: 0, purchases: 0 };
    
    tooltip.innerHTML = `
        <h4>${region}</h4>
        <div class="stat">
            <span class="stat-label">Besoins:</span>
            <span class="stat-value">${data.needs || 0}</span>
        </div>
        <div class="stat">
            <span class="stat-label">Dons:</span>
            <span class="stat-value">${data.gifts || 0}</span>
        </div>
        <div class="stat">
            <span class="stat-label">Distributions:</span>
            <span class="stat-value">${data.distributions || 0}</span>
        </div>
        <p style="color: #4facfe; margin-top: 10px; font-size: 11px;">📍 Cliquer pour plus de détails</p>
    `;
    
    updateTooltipPosition(tooltip, event);
    tooltip.style.display = 'block';
    tooltip.classList.add('show');
}

// Mettre à jour la position du tooltip
function updateTooltipPosition(tooltip, event) {
    const x = event.pageX; // Utiliser pageX/pageY au lieu de clientX/clientY
    const y = event.pageY;
    const offset = 15;
    
    tooltip.style.left = (x + offset) + 'px';
    tooltip.style.top = (y + offset) + 'px';
}

// Cacher le tooltip
function hideTooltip(tooltip) {
    tooltip.style.display = 'none';
    tooltip.classList.remove('show');
}

// Afficher le modal avec les détails
function showModal(modal, region) {
    const data = cityData[region] || { needs: 0, gifts: 0, distributions: 0, purchases: 0 };
    
    document.getElementById('modal-region-name').textContent = region;
    document.getElementById('modal-needs').textContent = data.needs || 0;
    document.getElementById('modal-gifts').textContent = data.gifts || 0;
    document.getElementById('modal-distributions').textContent = data.distributions || 0;
    document.getElementById('modal-purchases').textContent = data.purchases || 0;
    
    modal.classList.add('show');
}

// Fermer le modal
function closeModal(modal) {
    modal.classList.remove('show');
}

// Créer une légende pour la carte
function createMapLegend() {
    const mapContainer = document.querySelector('.map-container');
    if (!mapContainer) return;
    
    // Vérifier si la légende existe déjà
    if (mapContainer.querySelector('.map-legend')) return;
    
    const legend = document.createElement('div');
    legend.className = 'map-legend';
    legend.style.pointerEvents = 'none'; // La légende ne doit pas intercepter les événements de souris
    
    
    mapContainer.appendChild(legend);
    console.log('Légende créée');
}

// Initialiser au chargement de la page
document.addEventListener('DOMContentLoaded', async () => {
    console.log('DOMContentLoaded - Démarrage...');
    await loadCityData();
    initInteractiveMap();
    createMapLegend();
    console.log('Initialisation terminée');
});

document.addEventListener('DOMContentLoaded', function () {
    const toggleTachesBtn = document.getElementById('toggleTaches');
    const tacheSection = document.getElementById('tacheSection');
    const tacheContainer = document.getElementById('tacheContainer');
    const addTacheBtn = document.getElementById('addTache');

    let tacheIndex = 1;

    toggleTachesBtn.addEventListener('click', () => {
        tacheSection.classList.toggle('hidden');
    });

    function addDeleteEventListeners(container) {
        container.querySelectorAll('.deleteTache').forEach(button => {
            button.addEventListener('click', function () {
                const tacheItem = button.closest('.tacheItem');
                if (tacheContainer.children.length > 1) {
                    tacheItem.remove();
                } else {
                    alert("Vous devez avoir au moins une tâche.");
                }
            });
        });
    }

    function cloneTacheItem() {
        const originalTache = document.querySelector('.tacheItem');
        const newTache = originalTache.cloneNode(true);

        newTache.querySelectorAll('input, textarea, select').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${tacheIndex}]`);
                input.setAttribute('name', newName);
            }

            if (input.tagName === 'SELECT') {
                input.selectedIndex = -1;
            } else if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });

        tacheContainer.appendChild(newTache);
        addDeleteEventListeners(newTache);
        tacheIndex++;
    }

    addTacheBtn.addEventListener('click', cloneTacheItem);

    // Appliquer l'événement à la tâche initiale
    addDeleteEventListeners(tacheContainer);
});

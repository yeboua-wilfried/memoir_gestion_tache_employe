document.addEventListener('DOMContentLoaded', function () {
    const toggleTachesBtn = document.getElementById('toggleTaches');
    const tacheSection = document.getElementById('tacheSection');
    const tacheContainer = document.getElementById('tacheContainer');
    const addTacheBtn = document.getElementById('addTache');

    let tacheIndex = 1;

    toggleTachesBtn.addEventListener('click', () => {
        tacheSection.classList.toggle('hidden');
    });

    addTacheBtn.addEventListener('click', function () {
        const newTache = document.querySelector('.tacheItem').cloneNode(true);

        newTache.querySelectorAll('input, textarea, select').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${tacheIndex}]`);
                input.setAttribute('name', newName);
            }

            if (input.tagName === 'SELECT') {
                input.selectedIndex = -1;
            } else {
                input.value = '';
            }
        });

        tacheContainer.appendChild(newTache);
        tacheIndex++;
    });
});

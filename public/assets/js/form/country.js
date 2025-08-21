document.addEventListener('DOMContentLoaded', function () {
    const continentSel = document.getElementById('continent');
    const countrySel   = document.getElementById('country');
    const baseUrl      = continentSel.dataset.url;

    async function fetchCountries(continentId) {
        if (!continentId) return;
        const res = await fetch(`${baseUrl}/${continentId}`, {
            headers: { 'Accept': 'application/json' }
        });
        const list = await res.json();
        countrySel.innerHTML = '<option disabled selected hidden>Choose...</option>';
        list.forEach(c => {
            const o = document.createElement('option');
            o.value = c.id;
            o.textContent = c.name;
            countrySel.appendChild(o);
        });
    }

    continentSel.addEventListener('change', function () {
        fetchCountries(this.value);
    });
});

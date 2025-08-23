document.addEventListener('DOMContentLoaded', function () {
    const continentSel = document.getElementById('continent');
    const countrySel   = document.getElementById('country');
    const baseUrl      = continentSel.dataset.url;
    const prevCountry  = String(continentSel.dataset.prevCountry || '');

    async function fetchCountries(continentId) {
        if (!continentId) return;
        const res  = await fetch(`${baseUrl}/${continentId}`, { headers: { 'Accept': 'application/json' } });
        const list = await res.json();

        countrySel.innerHTML = '<option value="" disabled hidden>Choose...</option>';
        list.forEach(c => {
            const o = document.createElement('option');
            o.value = String(c.id);
            o.textContent = c.name;
            countrySel.appendChild(o);
        });
        
        if (prevCountry) {
            countrySel.value = prevCountry;
        }
    }
    
    if (continentSel.value) {
        fetchCountries(continentSel.value);
    }

    continentSel.addEventListener('change', function () {
        
        countrySel.innerHTML = '<option value="" disabled hidden>Choose...</option>';
        fetchCountries(this.value);
    });
    
    const jobSel     = document.getElementById('job');
    const subJobSel  = document.getElementById('sub_job');
    const prevSubJob = String(jobSel.dataset.prevSubjob || '');

    function setPlaceholder(selectEl, text = 'Choose...') {
        selectEl.innerHTML = '';
        const ph = document.createElement('option');
        ph.value = '';
        ph.textContent = text;
        ph.disabled = true;
        ph.selected = true;
        ph.hidden = true;
        selectEl.appendChild(ph);
    }

    async function populateSubJobs(jobId, preselectId = null) {
        setPlaceholder(subJobSel);
        if (!jobId) return;

        try {
            const r = await fetch(`/get-sub-jobs/${jobId}`, { headers: { 'Accept': 'application/json' } });
            const items = await r.json();
            items.forEach(item => {
                const o = document.createElement('option');
                o.value = String(item.id);
                o.textContent = item.name;
                subJobSel.appendChild(o);
            });
            if (preselectId) subJobSel.value = String(preselectId);
        } catch (e) {
            // silent fail
        }
    }
    
    if (jobSel.value) {
        populateSubJobs(jobSel.value, prevSubJob || null);
    }

    jobSel.addEventListener('change', function () {
        populateSubJobs(this.value, null);
    });
});

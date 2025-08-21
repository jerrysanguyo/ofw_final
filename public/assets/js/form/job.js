document.addEventListener('DOMContentLoaded', function() {
    const jobTypeSel = document.getElementById('job_type');
    const jobSel = document.getElementById('job');
    const subJobSel = document.getElementById('sub_job');

    const originalJobOptions = Array.from(jobSel.options).map(o => ({
        value: o.value,
        text: o.text,
        name: (o.dataset.name || o.text)
    }));

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

    function rebuildJobOptions(filterFn) {
        const current = jobSel.value;
        setPlaceholder(jobSel);

        originalJobOptions.forEach(opt => {
            if (opt.value === '') return;
            if (!filterFn || filterFn(opt)) {
                const o = document.createElement('option');
                o.value = opt.value;
                o.textContent = opt.text;
                o.dataset.name = opt.name;
                jobSel.appendChild(o);
            }
        });

        const stillThere = Array.from(jobSel.options).some(o => o.value === current);
        if (stillThere) jobSel.value = current;
        else jobSel.selectedIndex = 0;
    }

    function populateSubJobs(jobId, preselectId = null) {
        setPlaceholder(subJobSel);
        if (!jobId) return;

        fetch(`/get-sub-jobs/${jobId}`)
            .then(r => r.json())
            .then(items => {
                items.forEach(item => {
                    const o = document.createElement('option');
                    o.value = item.id;
                    o.textContent = item.name;
                    subJobSel.appendChild(o);
                });

                if (preselectId) subJobSel.value = String(preselectId);
                const isSeaJob = getSelectedJobName().toLowerCase().includes('sea');
                if (isSeaJob && !preselectId) {
                    const seaOpt = Array.from(subJobSel.options).find(o => o.text.toLowerCase().includes(
                        'sea'));
                    if (seaOpt) subJobSel.value = seaOpt.value;
                }
            })
            .catch(() => {});
    }

    function getSelectedJobName() {
        const opt = jobSel.options[jobSel.selectedIndex];
        return opt ? (opt.dataset.name || opt.text) : '';
    }

    function selectSeaEverywhere() {
        rebuildJobOptions(opt => opt.name.toLowerCase().includes('sea'));
        const seaOption = Array.from(jobSel.options).find(o => o.text.toLowerCase().includes('sea'));
        if (seaOption) jobSel.value = seaOption.value;

        populateSubJobs(jobSel.value);
    }

    function removeSeaFromJobs() {
        rebuildJobOptions(opt => !opt.name.toLowerCase().includes('sea'));
        setPlaceholder(subJobSel);
    }

    jobTypeSel.addEventListener('change', function() {
        if (this.value === 'seabase') {
            selectSeaEverywhere();
        } else if (this.value === 'landbase') {
            removeSeaFromJobs();
        } else {
            rebuildJobOptions();
            setPlaceholder(subJobSel);
        }
    });

    jobSel.addEventListener('change', function() {
        const jobId = this.value;
        populateSubJobs(jobId);
    });

    (function initOnLoad() {
        const initialJobType = jobTypeSel.value;
        const initialJobId = jobSel.value || null;
        const initialSubJob = "{{ isset($previousJob) ? ($previousJob->sub_job_id ?? '') : '' }}";

        if (initialJobType === 'seabase') {
            selectSeaEverywhere();
            if (initialSubJob) {
                setTimeout(() => populateSubJobs(jobSel.value, initialSubJob), 0);
            }
            return;
        }

        if (initialJobType === 'landbase') {
            removeSeaFromJobs();
        } else {
            rebuildJobOptions();
        }

        if (initialJobId) populateSubJobs(initialJobId, initialSubJob || null);
    })();
});
(function () {
    const form    = document.getElementById('continentForm');
    const btn     = document.getElementById('countroCountBtn');
    const totalEl = document.getElementById('countroCount');
    const listEl  = document.getElementById('countryList');

    if (!form || !btn || !totalEl || !listEl) return;

    function setLoading(state) {
        if (!btn) return;
        if (state) {
        btn.classList.add('loading');
        btn.setAttribute('disabled', 'disabled');
        } else {
        btn.classList.remove('loading');
        btn.removeAttribute('disabled');
        }
    }

    function countUp(el, to) {
        const dur = 700, from = 0, start = performance.now();
        const easeOutCubic = t => 1 - Math.pow(1 - t, 3);
        const fmt = n => new Intl.NumberFormat().format(n);
        function frame(ts) {
        const p = Math.min((ts - start) / dur, 1);
        const val = Math.round(from + (to - from) * easeOutCubic(p));
        el.textContent = fmt(val);
        if (p < 1) requestAnimationFrame(frame);
        }
        requestAnimationFrame(frame);
    }

    async function handleSubmit(e) {
        e.preventDefault();
        const action = form.getAttribute('action');
        const token  = form.querySelector('input[name=_token]')?.value || '';
        const continent_id = form.continent_id?.value || '';

        setLoading(true);
        totalEl.textContent = '—';
        listEl.innerHTML = '';

        try {
        const res = await fetch(action, {
            method: 'POST',
            headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ continent_id })
        });

        if (!res.ok) {
            const text = await res.text();
            throw new Error(text || 'Request failed');
        }

        const data = await res.json();
        const total = Number(data.total || 0);
        countUp(totalEl, total);

        const countries = Array.isArray(data.countries) ? data.countries : [];
        listEl.innerHTML = countries.length
            ? countries.map(c => `<li class="py-1">${c.country_name} — <strong>${new Intl.NumberFormat().format(c.count)}</strong></li>`).join('')
            : '<li class="text-muted">No records found.</li>';
        } catch (err) {
        console.error(err);
        totalEl.textContent = '—';
        listEl.innerHTML = '<li class="text-danger">Unable to load data. Please try again.</li>';
        } finally {
        setLoading(false);
        }
    }

    form.addEventListener('submit', handleSubmit);
})();
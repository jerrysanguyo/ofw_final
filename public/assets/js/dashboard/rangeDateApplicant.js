(function () {
    const form = document.getElementById('applicantCountForm');
    const btn  = document.getElementById('applicantCountBtn');
    const outEl = document.getElementById('applicantCount');
    const metaEl = document.getElementById('applicantCountMeta');

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
        if (!form) return;

        const action = form.getAttribute('action');
        const token  = form.querySelector('input[name=_token]')?.value || '';
        const startDate = form.startDate.value || '';
        const endDate   = form.endDate.value || '';

        setLoading(true);
        metaEl.textContent = '';

        try {
            const res = await fetch(action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ startDate, endDate })
            });

        if (!res.ok) {
            const text = await res.text();
            throw new Error(text || 'Request failed');
        }

            const data = await res.json();
            const count = Number(data.count || 0);
            countUp(outEl, count);

            const startTxt = data.startDate ? data.startDate : '—';
            const endTxt   = data.endDate   ? data.endDate   : '—';
            metaEl.textContent = `Range: ${startTxt} to ${endTxt}`;
        } catch (err) {
            outEl.textContent = '—';
            metaEl.textContent = 'Unable to generate count. Please try again.';
            console.error(err);
        } finally {
            setLoading(false);
        }
    }

    if (form) form.addEventListener('submit', handleSubmit);
})();
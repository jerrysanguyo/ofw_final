(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const ALLOW_REVERT = true;

    let modalState = { id: null, desired: 'approved', $switch: null, url: null };

    $(document).on('change', '.js-status-switch', function (e) {
        e.preventDefault();

        const $sw   = $(this);
        const id    = $sw.data('id');
        const name  = $sw.data('name') || 'this user';
        const curr  = ($sw.data('current') || 'pending').toLowerCase();
        const url   = $sw.data('url');

        const attemptedChecked = $sw.is(':checked');
        const attemptedStatus  = attemptedChecked ? 'approved' : 'pending';
        $sw.prop('checked', curr === 'approved');

        if (!ALLOW_REVERT && curr === 'approved' && attemptedStatus === 'pending') return;

        modalState = { id, desired: attemptedStatus, $switch: $sw, url };

        $('#modalUserName').text(name);
        $('#modalTargetStatus').text(attemptedStatus);
        $('#statusRemarks').val('');
        $('#statusConfirmModal').modal('show');
    });

    $('#confirmStatusBtn').on('click', function () {
        const { id, desired, $switch, url } = modalState;
        if (!id || !url) return;

        const remarks = $('#statusRemarks').val();

        $.ajax({
        url: url,
        method: 'PATCH',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        data: { status: desired, remarks },
        })
        .done(function (resp) {
        const isApproved = resp.status === 'approved';
        $switch.prop('checked', isApproved).data('current', resp.status);
        $('#status-text-' + id).text(resp.status);
        $('#statusConfirmModal').modal('hide');
        })
        .fail(function (xhr) {
        alert('Failed to update status. Please try again.');
        });
    });

    $('#statusConfirmModal').on('hidden.bs.modal', function () {
        modalState = { id: null, desired: 'approved', $switch: null, url: null };
    });
})();

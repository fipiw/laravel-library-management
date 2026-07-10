document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.app-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.querySelector('[data-toggle="sidebar"]');

    if (toggleBtn && sidebar && overlay) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    document.querySelectorAll('[data-confirm-delete]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const message = form.getAttribute('data-confirm-delete') || 'Yakin ingin menghapus data ini?';
            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('.alert-system[data-autohide]').forEach(function (alertEl) {
        setTimeout(function () {
            alertEl.style.transition = 'opacity .3s ease';
            alertEl.style.opacity = '0';
            setTimeout(function () { alertEl.remove(); }, 300);
        }, 4000);
    });
});

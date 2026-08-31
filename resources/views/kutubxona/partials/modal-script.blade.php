<script>
document.addEventListener('DOMContentLoaded', function () {

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    document.querySelectorAll('.btn-kitoblar').forEach(function (btn) {

        btn.addEventListener('click', function () {

            var fio = btn.getAttribute('data-fio') || '';
            var berilganRaw = btn.getAttribute('data-berilgan') || '';
            var berilmaganRaw = btn.getAttribute('data-berilmagan') || '';

            var berilgan = berilganRaw ? berilganRaw.split('||').filter(Boolean) : [];
            var berilmagan = berilmaganRaw ? berilmaganRaw.split('||').filter(Boolean) : [];

            document.getElementById('kitoblarModalFio').textContent = fio;

            var berilganHtml = '';
            var berilmaganHtml = '';

            if (berilgan.length > 0) {
                berilganHtml += '<h6 class="text-success fw-bold mb-2"><i class="bi bi-check-circle me-1"></i> Berilgan darsliklar</h6>';
                berilganHtml += '<div class="d-flex flex-wrap gap-2">';
                berilgan.forEach(function (item) {
                    berilganHtml += '<span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2">' + escapeHtml(item) + '</span>';
                });
                berilganHtml += '</div>';
            }

            if (berilmagan.length > 0) {
                berilmaganHtml += '<h6 class="text-danger fw-bold mb-2 mt-3"><i class="bi bi-x-circle me-1"></i> Berilmagan darsliklar</h6>';
                berilmaganHtml += '<div class="d-flex flex-wrap gap-2">';
                berilmagan.forEach(function (item) {
                    berilmaganHtml += '<span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2">' + escapeHtml(item) + '</span>';
                });
                berilmaganHtml += '</div>';
            }

            document.getElementById('kitoblarModalBerilgan').innerHTML = berilganHtml;
            document.getElementById('kitoblarModalBerilmagan').innerHTML = berilmaganHtml;

            var emptyEl = document.getElementById('kitoblarModalEmpty');
            emptyEl.style.display = (berilgan.length === 0 && berilmagan.length === 0) ? 'block' : 'none';

        });

    });

});
</script>
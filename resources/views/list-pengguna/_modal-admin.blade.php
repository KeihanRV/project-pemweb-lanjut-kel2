<!-- Admin Modal -->
<div id="adminModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 id="adminModalTitle" class="text-lg font-semibold">Ubah Hak Admin</h3>
        <p class="text-sm text-gray-600 mt-2" id="adminModalMessage"></p>

        <div class="mt-4 flex justify-end gap-2">
            <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeAdminModal()">Batal</button>
            <form id="adminForm" method="POST" action="" class="inline">
                @csrf
                @method('PATCH')
                <input type="hidden" name="is_admin" id="adminFormIsAdmin" value="0">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Ya, lanjutkan</button>
            </form>
        </div>
    </div>
</div>

<script>
function openAdminModal(el) {
    var id = el.dataset.id;
    var name = el.dataset.name;
    var isAdmin = el.dataset.admin === '1';
    var modal = document.getElementById('adminModal');
    var form = document.getElementById('adminForm');
    var hiddenInput = document.getElementById('adminFormIsAdmin');
    var title = document.getElementById('adminModalTitle');
    var message = document.getElementById('adminModalMessage');

    form.action = '{{ url('/pengguna') }}/' + id + '/admin';
    hiddenInput.value = isAdmin ? '0' : '1';

    if (isAdmin) {
        title.textContent = 'Cabut Hak Admin';
        message.textContent = 'Apakah anda yakin ingin mencabut hak admin dari user ' + name + '?';
    } else {
        title.textContent = 'Grant Admin';
        message.textContent = 'Apakah anda yakin ingin membuat user ' + name + ' menjadi admin?';
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAdminModal() {
    var modal = document.getElementById('adminModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>

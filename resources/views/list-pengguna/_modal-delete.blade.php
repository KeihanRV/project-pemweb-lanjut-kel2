<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold">Hapus Pengguna</h3>
        <p class="text-sm text-gray-600 mt-2">Apakah Anda yakin ingin menghapus pengguna <span id="deleteUserName" class="font-medium"></span>?</p>

        <div class="mt-4 flex justify-end gap-2">
            <button type="button" class="px-4 py-2 border rounded-lg" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" action="" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(el){
    var id = el.dataset.id;
    var name = el.dataset.name;
    var modal = document.getElementById('deleteModal');
    var form = document.getElementById('deleteForm');
    document.getElementById('deleteUserName').textContent = name;
    form.action = '{{ url('/pengguna') }}/' + id;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeDeleteModal(){
    var modal = document.getElementById('deleteModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>

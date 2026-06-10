<script>
    function toggleSidebar(open) {
        const sb = document.getElementById('sidebar');
        const ov = document.getElementById('sidebar-overlay');
        if (open) {
            sb.classList.remove('translate-x-full');
            sb.classList.add('translate-x-0');
            ov.classList.remove('hidden');
        } else {
            sb.classList.add('translate-x-full');
            sb.classList.remove('translate-x-0');
            ov.classList.add('hidden');
        }
    }




    document.getElementById('dm-select').addEventListener('change', function () {
        if (!this.value) return;
        fetch('{{ route('chat.dm') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ user_id: this.value })
        }).then(r => { if (r.redirected) window.location = r.url; });
        this.value = '';
    });


</script>

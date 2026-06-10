<x-layout chat_roll=true pageTitle="Amir" logo="{{asset('/amhub.png')}}" title="چت">
    <x-slot name="title">چت</x-slot>

    <div class="flex h-[calc(100vh-64px)] overflow-hidden relative">

        <x-chat-sidebar
            :conversations="$conversations"
            :allUsers="$users"
            :activeConversation="null"
        />

        {{-- main — موبایل: تمام صفحه / دسکتاپ: کنار sidebar --}}
        <main class="flex-1 flex items-center justify-center bg-base-100">
            <div class="text-center text-base-content/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-3 opacity-30"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-lg">یک مکالمه انتخاب کن</p>

                {{-- روی موبایل sidebar باز نیست، پس یه دکمه بده --}}
                <button onclick="toggleSidebar(true)"
                        class="btn btn-primary btn-sm mt-4 lg:hidden">
                    مکالمه‌ها
                </button>
            </div>
        </main>
    </div>

    {{-- Modal گروه --}}
    <dialog id="modal-group" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">گروه جدید</h3>
            <form method="POST" action="{{ route('chat.group') }}">
                @csrf
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">نام گروه</span></label>
                    <input type="text" name="name" placeholder="مثلاً: تیم توسعه"
                           required class="input input-bordered w-full">
                </div>
                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">اعضا</span></label>
                    <div class="bg-base-200 rounded-box p-3 max-h-48 overflow-y-auto flex flex-col gap-2">
                        @foreach($users as $u)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="user_ids[]"
                                       value="{{ $u->id }}" class="checkbox checkbox-sm checkbox-primary">
                                <span class="text-sm">{{ $u->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('modal-group').close()"
                            class="btn btn-ghost">لغو</button>
                    <button type="submit" class="btn btn-primary">ساخت گروه</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop"><button>بستن</button></form>
    </dialog>

    <x-chat-scripts />

    <script>
        function toggleSidebar(open) {
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');

            if (open) {
                sb.style.display = 'flex';
                sb.style.position = 'fixed';
                sb.style.top = '0';
                sb.style.right = '0';
                sb.style.height = '100%';
                sb.style.width = '18rem';
                sb.style.zIndex = '30';
                ov.classList.remove('hidden');
            } else {
                if (window.innerWidth < 1024) {
                    sb.style.display = 'none';
                    sb.style.position = '';
                }
                ov.classList.add('hidden');
            }
        }
        function fetchOnline() {
            fetch('{{ route('chat.online') }}')
                .then(r => r.json())
                .then(users => {
                    const el = document.getElementById('online-users-list');
                    if (!users.length) {
                        el.innerHTML = '<span class="text-xs text-base-content/30">کسی آنلاین نیست</span>';
                        return;
                    }

                    const visible = users.slice(0, 4);
                    const extra   = users.length - visible.length;

                    const avatars = visible.map(u => {
                        const src = u.avatar
                            ? `/storage/${u.avatar}`
                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&size=40&background=random`;
                        return `
                    <div class="avatar tooltip" data-tip="${u.name}">
                        <div class="w-8 rounded-full ring-2 ring-base-100">
                            <img src="${src}" alt="${u.name}">
                        </div>
                    </div>`;
                    }).join('');

                    const extraHtml = extra > 0 ? `
                <div class="avatar avatar-placeholder">
                    <div class="bg-neutral text-neutral-content rounded-full w-8">
                        <span class="text-xs">+${extra}</span>
                    </div>
                </div>` : '';

                    el.innerHTML = `<div class="avatar-group -space-x-3">${avatars}${extraHtml}</div>`;
                });
        }
        fetchOnline();
        setInterval(fetchOnline, 15000);
    </script>


</x-layout>

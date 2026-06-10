<x-layout chat_roll=true  pageTitle="Amir" logo="{{asset('/amhub.png')}}" title="چت">
    <x-slot name="title">
        {{ $conversation->type === 'group' ? $conversation->name : $conversation->otherUser()?->name }}
    </x-slot>

    <div class="flex h-[calc(100vh-64px)] overflow-hidden relative">

        <x-chat-sidebar
            :conversations="$conversations"
            :allUsers="$allUsers"
            :activeConversation="$conversation"
        />

        {{-- پنجره چت --}}
        <main class="flex-1 flex flex-col bg-base-100 min-w-0">

            {{-- هدر --}}
            <div class="px-4 py-3 border-b border-base-300 bg-base-200 flex items-center gap-3 shrink-0">

                <button onclick="toggleSidebar(true)"
                        class="btn btn-ghost btn-sm btn-square lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="avatar">
                    <div class="rounded-full w-10">
                        @php $other = $conversation->otherUser(); @endphp
                        @if($conversation->type === 'group')
                            <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold">#</div>
                        @elseif($other?->avatar)
                            <img src="{{ asset('storage/' . $other->avatar) }}" alt="{{ $other->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($other?->name ?? '?') }}&background=random" alt="">
                        @endif
                    </div>
                </div>

                <div class="flex-1 min-w-0">
                    <p class="font-bold leading-tight truncate">
                        {{ $conversation->type === 'group' ? $conversation->name : $conversation->otherUser()?->name }}
                    </p>
                    <p class="text-xs text-base-content/50">
                        @if($conversation->type === 'group')
                            {{ $participants->count() }} عضو
                        @else
                            پیام مستقیم
                        @endif
                    </p>
                </div>

                @if($conversation->type === 'group')
                    <div class="dropdown dropdown-end">
                        <button tabindex="0" class="btn btn-ghost btn-sm btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <ul tabindex="0" class="dropdown-content menu bg-base-200 rounded-box shadow-lg w-52 p-2 z-10">
                            @foreach($participants as $p)
                                <li class="menu-disabled">
                                    <span class="text-xs">{{ $p->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- پیام‌ها --}}
            <div id="messages" class="flex-1 overflow-y-auto p-4 flex flex-col gap-2">
                @foreach($messages->sortBy('created_at') as $msg)
                    <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-start' : 'justify-end' }} items-end gap-2"
                         data-id="{{ $msg->id }}">

                        @if($msg->user_id !== auth()->id())
                            <div class="avatar shrink-0">
                                <div class="rounded-full w-7">
                                    @if($msg->user->avatar)
                                        <img src="{{ asset('storage/' . $msg->user->avatar) }}" alt="{{ $msg->user->name }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($msg->user->name) }}&size=28&background=random" alt="">
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="max-w-[70%] lg:max-w-md">
                            @if($conversation->type === 'group' && $msg->user_id !== auth()->id())
                                <p class="text-xs text-base-content/50 mb-1 px-1">{{ $msg->user->name }}</p>
                            @endif
                            <div class="rounded-2xl px-4 py-2 text-sm break-words
                                {{ $msg->user_id === auth()->id()
                                    ? 'bg-base-300 text-base-content rounded-br-sm'
                                    : 'bg-primary text-primary-content rounded-bl-sm' }}">
                                {{ $msg->body }}
                            </div>
                            <p class="text-xs text-base-content/30 mt-1 px-1
                                {{ $msg->user_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                {{ $msg->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- فرم ارسال --}}
            <div class="p-3 border-t border-base-300 bg-base-200 shrink-0">
                <div class="flex gap-2 items-center">
                    <input type="text" id="msg-input"
                           placeholder="پیامت رو بنویس..."
                           autocomplete="off"
                           class="input input-bordered flex-1 text-sm rounded-2xl"
                           onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); sendMessage(); }">
                    <button onclick="sendMessage()" id="send-btn"
                            class="btn btn-primary rounded-2xl px-5 gap-2 shrink-0">
                        <span class="hidden sm:inline text-sm">ارسال</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
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
                        @foreach($allUsers as $u)
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

    <script>
        const CONV_ID  = {{ $conversation->id }};
        const CSRF     = '{{ csrf_token() }}';
        const IS_GROUP = {{ $conversation->type === 'group' ? 'true' : 'false' }};
        let lastId     = {{ $messages->last()?->id ?? 0 }};

        function scrollBottom(smooth = false) {
            const c = document.getElementById('messages');
            setTimeout(() => {
                c.scrollTop = c.scrollHeight;
            }, 50);
        }
        setTimeout(() => scrollBottom(), 100);

        function escapeHtml(str) {
            return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }

        function renderMessage(msg) {
            const isMine = msg.is_mine;
            const wrap   = document.createElement('div');
            wrap.className = `flex ${isMine ? 'justify-start' : 'justify-end'} items-end gap-2`;
            wrap.dataset.id = msg.id;

            const avatarSrc = msg.avatar
                ? `/storage/${msg.avatar}`
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(msg.user)}&size=28&background=random`;


            const avatarHtml = !isMine ? `
                <div class="avatar shrink-0">
                    <div class="rounded-full w-7 overflow-hidden">
                        <img src="${avatarSrc}" alt="">
                    </div>
                </div>` : '';

            const authorHtml = IS_GROUP && !isMine
                ? `<p class="text-xs text-base-content/50 mb-1 px-1">${escapeHtml(msg.user)}</p>` : '';

            wrap.innerHTML = `
                ${avatarHtml}
                <div class="max-w-[70%] lg:max-w-md">
                    ${authorHtml}
                    <div class="rounded-2xl px-4 py-2 text-sm break-words
                        ${isMine ? 'bg-base-300 text-base-content rounded-br-sm' : 'bg-primary text-primary-content rounded-bl-sm'}">
                        ${escapeHtml(msg.body)}
                    </div>
                    <p class="text-xs text-base-content/30 mt-1 px-1 ${isMine ? 'text-right' : 'text-left'}">
                        ${msg.created_at}
                    </p>
                </div>`;

            document.getElementById('messages').appendChild(wrap);
        }

        function sendMessage() {
            const input = document.getElementById('msg-input');
            const btn   = document.getElementById('send-btn');
            const body  = input.value.trim();
            if (!body) return;
            input.value = '';
            btn.disabled = true;

            fetch(`/chat/${CONV_ID}/messages`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ body })
            })
                .then(r => r.json())
                .then(msg => {
                    renderMessage(msg);
                    lastId = msg.id;
                    scrollBottom(true);
                })
                .finally(() => { btn.disabled = false; input.focus(); });
        }

        function poll() {
            fetch(`/chat/${CONV_ID}/poll?after_id=${lastId}`)
                .then(r => r.json())
                .then(msgs => {
                    msgs.forEach(msg => {
                        if (!document.querySelector(`[data-id="${msg.id}"]`)) {
                            renderMessage(msg);
                            lastId = msg.id;
                        }
                    });
                    if (msgs.length) scrollBottom(true);
                });
        }
        setInterval(poll, 3000);


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

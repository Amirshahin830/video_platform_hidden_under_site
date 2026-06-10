@props([
    'conversations',
    'allUsers',
    'activeConversation' => null,
])

{{-- Overlay — فقط موبایل --}}
<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/40 z-20 hidden"
     onclick="toggleSidebar(false)"></div>

{{-- Sidebar --}}
<aside id="sidebar"
       class="hidden lg:flex flex-col w-80 shrink-0
              bg-base-200 border-l border-base-300
              h-full overflow-hidden">

    {{-- آنلاین‌ها --}}

{{--    <div class="p-3 border-b border-base-300 bg-base-100">--}}
{{--        <p class="text-xs text-base-content/50 mb-2 font-bold">● آنلاین</p>--}}
{{--        <div id="online-users-list" class="flex items-center gap-2 min-h-8">--}}
{{--            <span class="text-xs text-base-content/30">در حال بارگذاری...</span>--}}
{{--        </div>--}}
{{--    </div>--}}

    {{-- دکمه‌های اکشن --}}
    <div class="p-3 border-b border-base-300 flex gap-2">
        <select id="dm-select" class="select select-sm select-bordered flex-1 text-sm">
            <option value="">✉ پیام مستقیم...</option>
            @foreach($allUsers as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
        <button onclick="document.getElementById('modal-group').showModal()"
                class="btn btn-sm btn-primary">+ گروه</button>
    </div>

    {{-- لیست مکالمات --}}
    <ul class="flex-1 overflow-y-auto divide-y divide-base-300">
        @forelse($conversations as $conv)
            <li>
                <a href="{{ route('chat.show', $conv) }}"
                   onclick="toggleSidebar(false)"
                   class="flex items-center gap-3 px-4 py-3 transition-colors
                      {{ $activeConversation && $conv->id === $activeConversation->id
                            ? 'bg-primary/10 border-r-2 border-primary'
                            : 'hover:bg-base-300' }}">

                    <div class="avatar">
                        <div class="rounded-full w-10">
                            @php $person = $conv->type === 'group' ? null : $conv->otherUser(); @endphp
                            @if($conv->type === 'group')
                                <div class="w-10 h-10 rounded-full bg-neutral text-neutral-content flex items-center justify-center text-sm font-bold">#</div>
                            @elseif($person?->avatar)
                                <img src="{{ asset('storage/' . $person->avatar) }}" alt="{{ $person->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($person?->name ?? '?') }}&background=random" alt="">
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-sm truncate">
                                {{ $conv->type === 'group' ? $conv->name : $conv->otherUser()?->name }}
                            </span>
                            @if($conv->latestMessage)
                                <span class="text-xs text-base-content/40">
                                    {{ $conv->latestMessage->created_at->format('H:i') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-base-content/50 truncate">
                            {{ Str::limit($conv->latestMessage?->body, 35) }}
                        </p>
                    </div>

                    @if(isset($conv->unread_count) && $conv->unread_count)
                        <span class="badge badge-primary badge-sm">{{ $conv->unread_count }}</span>
                    @endif
                </a>
            </li>
        @empty
            <li class="p-6 text-center text-base-content/40 text-sm">هنوز مکالمه‌ای نداری</li>
        @endforelse
    </ul>
</aside>

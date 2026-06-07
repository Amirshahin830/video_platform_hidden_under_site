<x-layout title="{{ $video->title }}">



    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- ستون اصلی --}}
            <div class="flex-1 min-w-0 flex flex-col gap-4">

                {{-- پلیر ویدئو --}}

                <video id="player" controls class="w-full h-full object-cover">
                    @if($video->processing_status === 'done' && $video->path_360p)
                        <source src="{{ asset('storage/' . $video->path_360p) }}" type="video/mp4">
                    @else
                        <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                    @endif
                </video>

                @if($video->processing_status === 'done' && $video->path_original)
                    <div class="flex gap-2 mt-2">
                        <button onclick="changeQuality('{{ asset('storage/' . $video->path_360p) }}', this)"
                                class="btn btn-sm btn-primary" data-quality="360p">360p</button>
                        <button onclick="changeQuality('{{ asset('storage/' . $video->path_original) }}', this)"
                                class="btn btn-sm btn-ghost" data-quality="original">کیفیت اصلی</button>
                    </div>
                @endif

                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        const player = new Plyr('#player', {
                            controls: ['play-large','play','progress','current-time','duration','mute','volume','settings','fullscreen'],
                            settings: ['speed'],
                            speed: { selected: 1, options: [0.5, 0.75, 1, 1.25, 1.5, 2] },
                        });

                        window.changeQuality = function(src, btn) {
                            const vid = document.getElementById('player');
                            const currentTime = vid.currentTime;
                            const wasPaused = vid.paused;
                            vid.src = src;
                            vid.load();
                            vid.currentTime = currentTime;
                            if (!wasPaused) vid.play();
                            document.querySelectorAll('[data-quality]').forEach(b => b.classList.replace('btn-primary', 'btn-ghost'));
                            btn.classList.replace('btn-ghost', 'btn-primary');
                        }
                    });
                </script>

                {{-- عنوان و اطلاعات --}}
                <div class="flex flex-col gap-3">
                    <h1 class="text-lg font-medium">{{ $video->title }}</h1>

                    <div class="flex items-center justify-between flex-wrap gap-3">
                        {{-- آمار --}}
                        <div class="flex items-center gap-3 text-sm text-base-content/50">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($video->views) }} بازدید
                        </span>
                            <span>•</span>
                            <span>{{ $video->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- دکمه‌های لایک/دیسلایک --}}
                        @auth
                            <div class="flex items-center gap-2">
                                <form action="{{ route('videos.like', $video->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="like">
                                    <button type="submit"
                                            class="btn btn-sm gap-1 {{ $userLike === 'like' ? 'btn-primary' : 'btn-ghost' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="{{ $userLike === 'like' ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        {{ $video->likes_only_count }}
                                    </button>
                                </form>

                                <form action="{{ route('videos.like', $video->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="dislike">
                                    <button type="submit"
                                            class="btn btn-sm gap-1 {{ $userLike === 'dislike' ? 'btn-error' : 'btn-ghost' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="{{ $userLike === 'dislike' ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                                        </svg>
                                        {{ $video->dislikes_count }}
                                    </button>
                                </form>

                                {{-- حذف (صاحب ویدئو یا ادمین) --}}
                                @if(auth()->id() === $video->user_id || auth()->user()->hasRole('admin'))
                                    <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
                                          onsubmit="return confirm('ویدئو حذف شود؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-ghost btn-sm text-error">حذف</button>
                                    </form>
                                @endif
                            </div>
                        @endauth
                    </div>

                    <div class="divider my-0"></div>

                    {{-- اطلاعات کانال --}}
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                @if($video->user->avatar)
                                    <img src="{{ asset('storage/' . $video->user->avatar) }}" alt="">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($video->user->name) }}&background=random" alt="">
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-sm">{{ $video->user->name }}</p>
                            <p class="text-xs text-base-content/50">{{ $video->user->videos()->published()->count() }} ویدئو</p>
                        </div>
                    </div>

                    {{-- توضیحات --}}
                    @if($video->description)
                        <div class="bg-base-200 rounded-xl p-4 text-sm text-base-content/80 leading-relaxed whitespace-pre-line">
                            {{ $video->description }}
                        </div>
                    @endif
                </div>

                {{-- کامنت‌ها (بعداً) --}}
                <div class="divider"></div>
                <p class="text-sm text-base-content/40 text-center">بخش کامنت‌ها به زودی اضافه میشه</p>

            </div>

            {{-- ستون کناری — ویدئوهای مرتبط --}}
            <div class="w-full lg:w-80 flex-shrink-0 flex flex-col gap-3">
                <h2 class="text-sm font-medium text-base-content/60">ویدئوهای دیگر</h2>

                @foreach($related as $rel)
                    <a href="{{ route('videos.show', $rel->id) }}" class="flex gap-3 group">
                        <div class="relative w-36 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-base-300">
                            @if($rel->thumbnail)
                                <img src="{{ asset('storage/' . $rel->thumbnail) }}"
                                     alt="{{ $rel->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-base-content/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    </svg>
                                </div>
                            @endif
                            <span class="absolute bottom-1 end-1 bg-black/70 text-white text-xs px-1 rounded">
                        {{ $rel->formatted_duration }}
                    </span>
                        </div>
                        <div class="flex flex-col gap-1 min-w-0">
                            <p class="text-sm font-medium line-clamp-2 group-hover:text-primary transition-colors">{{ $rel->title }}</p>
                            <p class="text-xs text-base-content/50">{{ $rel->user->name }}</p>
                            <p class="text-xs text-base-content/40">{{ number_format($rel->views) }} بازدید</p>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-layout>

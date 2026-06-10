<x-layout chat_roll=true pageTitle="Amir" logo="{{asset('/amhub.png')}}" title="ویدئوها">
    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- هدر --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-medium">ویدئوها</h1>
            @auth
                <a href="{{ route('videos.create') }}" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    آپلود ویدئو
                </a>
            @endauth
        </div>

        {{-- گرید ویدئوها --}}
        @if($videos->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($videos as $video)
                    <a href="{{ route('videos.show', $video->id) }}" class="group flex flex-col gap-2">

                        {{-- thumbnail --}}
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-base-300">
                            @if($video->thumbnail)
                                <img src="{{ asset('storage/' . $video->thumbnail) }}"
                                     alt="{{ $video->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-base-content/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- مدت زمان --}}
                            <span class="absolute bottom-2 end-2 bg-black/70 text-white text-xs px-1.5 py-0.5 rounded">
                        {{ $video->formatted_duration }}
                    </span>
                        </div>

                        {{-- اطلاعات --}}
                        <div class="flex flex-col gap-1 px-1">
                            <h3 class="font-medium text-sm line-clamp-2 group-hover:text-primary transition-colors">
                                {{ $video->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-base-content/50 flex-wrap">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($video->views) }}
                        </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            {{ $video->likes_only_count ?? 0 }}
                        </span>
                                <span>•</span>
                                <span>{{ $video->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            {{-- pagination --}}
            <div class="mt-8">
                {{ $videos->links() }}
            </div>

        @else
            <div class="flex flex-col items-center justify-center py-24 text-base-content/40 gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.263a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                </svg>
                <p class="text-sm">هنوز ویدئویی آپلود نشده</p>
            </div>
        @endif

    </div>
</x-layout>

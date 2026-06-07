<x-layout title="آپلود ویدئو">
    <div class="max-w-2xl mx-auto px-4 py-8">

        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('home') }}" class="btn btn-ghost btn-sm btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-xl font-medium">آپلود ویدئو</h1>
        </div>

        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
            <input type="hidden" name="duration" id="durationInput" value="0">
            @csrf

            {{-- آپلود فایل ویدئو --}}
            <div class="form-control w-full">
                <div class="label"><span class="label-text">فایل ویدئو <span class="text-error">*</span></span></div>

                <label for="videoInput"
                       class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-base-300 rounded-xl cursor-pointer hover:border-primary hover:bg-base-200 transition-colors"
                       id="videoDropZone">
                    <div id="videoPlaceholder" class="flex flex-col items-center gap-2 text-base-content/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span class="text-sm">برای انتخاب کلیک کن یا فایل رو اینجا بکش</span>
                        <span class="text-xs">MP4, WebM, OGG — حداکثر ۵۰۰ مگابایت</span>
                    </div>
                    <div id="videoSelected" class="hidden flex-col items-center gap-2 text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium" id="videoFileName"></span>
                        <span class="text-xs text-base-content/50" id="videoFileSize"></span>
                    </div>
                    <input type="file" id="videoInput" name="video" class="hidden" accept="video/mp4,video/webm,video/ogg">
                </label>

                @error('video')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            {{-- thumbnail --}}
            <div class="form-control w-full">
                <div class="label"><span class="label-text">تصویر پیش‌نمایش (اختیاری)</span></div>

                <label for="thumbnailInput"
                       class="flex items-center gap-4 w-full p-4 border border-base-300 rounded-xl cursor-pointer hover:border-primary hover:bg-base-200 transition-colors">
                    <div id="thumbnailPreview" class="w-24 h-14 rounded-lg bg-base-300 overflow-hidden flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-medium" id="thumbnailLabel">انتخاب تصویر</span>
                        <span class="text-xs text-base-content/50">JPG, PNG, WebP — حداکثر ۲ مگابایت</span>
                    </div>
                    <input type="file" id="thumbnailInput" name="thumbnail" class="hidden" accept="image/*">
                </label>

                @error('thumbnail')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            {{-- عنوان --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">عنوان <span class="text-error">*</span></span></div>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="عنوان ویدئو را وارد کنید"
                       class="input input-bordered w-full @error('title') input-error @enderror">
                @error('title')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
            </label>

            {{-- توضیحات --}}
            <label class="form-control w-full">
                <div class="label"><span class="label-text">توضیحات (اختیاری)</span></div>
                <textarea name="description" rows="4"
                          placeholder="توضیحاتی درباره ویدئو بنویسید..."
                          class="textarea textarea-bordered w-full @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                @error('description')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
            </label>

            {{-- پروگرس آپلود --}}
            <div id="uploadProgress" class="hidden flex-col gap-2">
                <div class="flex justify-between text-xs text-base-content/60">
                    <span>در حال آپلود...</span>
                    <span id="uploadPercent">0%</span>
                </div>
                <progress id="uploadBar" class="progress progress-primary w-full" value="0" max="100"></progress>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">انصراف</a>
                <button type="submit" id="submitBtn" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    آپلود
                </button>
            </div>

        </form>
    </div>

    <script>
        document.getElementById('videoInput').addEventListener('change', function(){
            if(this.files[0]){
                const url = URL.createObjectURL(this.files[0]);
                const vid = document.createElement('video');
                vid.src = url;
                vid.addEventListener('loadedmetadata', function(){
                    document.getElementById('durationInput').value = Math.round(vid.duration);
                    URL.revokeObjectURL(url);
                });
            }
        });
        // نمایش نام فایل ویدئو
        document.getElementById('videoInput').addEventListener('change', function(){
            if(this.files[0]){
                const file = this.files[0];
                document.getElementById('videoPlaceholder').classList.add('hidden');
                document.getElementById('videoSelected').classList.remove('hidden');
                document.getElementById('videoSelected').classList.add('flex');
                document.getElementById('videoFileName').textContent = file.name;
                document.getElementById('videoFileSize').textContent = (file.size / 1024 / 1024).toFixed(1) + ' MB';
            }
        });

        // پیش‌نمایش thumbnail
        document.getElementById('thumbnailInput').addEventListener('change', function(){
            if(this.files[0]){
                const reader = new FileReader();
                reader.onload = e => {
                    const preview = document.getElementById('thumbnailPreview');
                    preview.innerHTML = '<img src="'+e.target.result+'" class="w-full h-full object-cover">';
                    document.getElementById('thumbnailLabel').textContent = this.files[0].name;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        // پروگرس بار آپلود
        document.querySelector('form').addEventListener('submit', function(e){
            const videoInput = document.getElementById('videoInput');
            if(!videoInput.files.length) return;

            e.preventDefault();
            const form = this;
            const formData = new FormData(form);

            document.getElementById('uploadProgress').classList.remove('hidden');
            document.getElementById('uploadProgress').classList.add('flex');
            document.getElementById('submitBtn').disabled = true;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);

            xhr.upload.addEventListener('progress', function(e){
                if(e.lengthComputable){
                    const pct = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('uploadBar').value = pct;
                    document.getElementById('uploadPercent').textContent = pct + '%';
                }
            });

            xhr.addEventListener('load', function(){
                if(xhr.status === 302 || xhr.status === 200){
                    const redirect = xhr.responseURL;
                    window.location.href = redirect;
                }
            });

            xhr.addEventListener('error', function(){
                document.getElementById('submitBtn').disabled = false;
                alert('خطا در آپلود. دوباره تلاش کنید.');
            });

            xhr.send(formData);
        });
    </script>
</x-layout>

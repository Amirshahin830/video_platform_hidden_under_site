<x-layout title="داشبورد">
    <div class="max-w-4xl mx-auto px-4 py-8 flex flex-col gap-6">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- مشخصات کاربر --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <h2 class="card-title text-base">مشخصات کاربر</h2>

                <div class="flex items-center gap-4 flex-wrap">
                    <div class="relative w-fit">
                        <div class="avatar">
                            <div class="w-20 rounded-full ring ring-base-300">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="avatar">
                                @endif
                            </div>
                        </div>
                        <label for="avatarInput"
                               class="absolute bottom-0 end-0 btn btn-xs btn-circle btn-neutral cursor-pointer"
                               title="تغییر عکس">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l2-3h10l2 3h2a1 1 0 011 1v11a1 1 0 01-1 1H3a1 1 0 01-1-1V8a1 1 0 011-1zm9 3a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                        </label>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-medium text-lg">{{ auth()->user()->name }}</span>
                        <div class="flex items-center gap-2 flex-wrap">
                            @forelse(auth()->user()->roles as $role)
                                <span class="badge badge-success badge-sm">{{ $role->label ?? $role->name }}</span>
                            @empty
                                <span class="badge badge-ghost badge-sm">بدون نقش</span>
                            @endforelse
                        </div>
                        <span class="text-sm text-base-content/60">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <div class="divider my-0"></div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="form-control w-full">
                            <div class="label"><span class="label-text">نام کامل</span></div>
                            <input type="text" name="name" value="{{ auth()->user()->name }}"
                                   class="input input-bordered w-full @error('name') input-error @enderror">
                            @error('name')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                        </label>

                        <label class="form-control w-full">
                            <div class="label"><span class="label-text">ایمیل</span></div>
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                   class="input input-bordered w-full @error('email') input-error @enderror">
                            @error('email')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="btn btn-primary btn-sm">ذخیره اطلاعات</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- تغییر رمز عبور --}}
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <h2 class="card-title text-base">تغییر رمز عبور</h2>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="flex flex-col gap-4">
                        <label class="form-control w-full">
                            <div class="label"><span class="label-text">رمز عبور فعلی</span></div>
                            <input type="password" name="current_password" placeholder="••••••••"
                                   class="input input-bordered w-full @error('current_password') input-error @enderror">
                            @error('current_password')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="form-control w-full">
                                <div class="label"><span class="label-text">رمز عبور جدید</span></div>
                                <input type="password" name="password" placeholder="••••••••"
                                       class="input input-bordered w-full @error('password') input-error @enderror">
                                @error('password')<span class="text-error text-xs mt-1">{{ $message }}</span>@enderror
                            </label>

                            <label class="form-control w-full">
                                <div class="label"><span class="label-text">تکرار رمز عبور جدید</span></div>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                       class="input input-bordered w-full">
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="btn btn-primary btn-sm">تغییر رمز</button>
                    </div>
                </form>
            </div>
        </div>

        @if(auth()->user()->hasRole('admin'))

            {{-- آمار --}}
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body gap-4">
                    <div class="flex items-center gap-2">
                        <h2 class="card-title text-base">آمار بازدید</h2>
                        <span class="badge badge-success badge-sm">ادمین</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="stat bg-base-200 rounded-box p-4">
                            <div class="stat-title text-xs">کل ویدئوها</div>
                            <div class="stat-value text-2xl">{{ $stats['videos'] ?? 0 }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-box p-4">
                            <div class="stat-title text-xs">بازدید کل</div>
                            <div class="stat-value text-2xl">{{ number_format($stats['views'] ?? 0) }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-box p-4">
                            <div class="stat-title text-xs">کاربران</div>
                            <div class="stat-value text-2xl">{{ $stats['users'] ?? 0 }}</div>
                        </div>
                        <div class="stat bg-base-200 rounded-box p-4">
                            <div class="stat-title text-xs">لایک‌های امروز</div>
                            <div class="stat-value text-2xl">{{ $stats['likes_today'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- مدیریت نقش --}}
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body gap-4">
                    <div class="flex items-center gap-2">
                        <h2 class="card-title text-base">مدیریت نقش کاربران</h2>
                        <span class="badge badge-success badge-sm">ادمین</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>کاربر</th>
                                <th>ایمیل</th>
                                <th>نقش فعلی</th>
                                <th>تغییر نقش</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <div class="avatar">
                                                <div class="w-8 rounded-full">
                                                    @if($user->avatar)
                                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="">
                                                    @else
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=32&background=random" alt="">
                                                    @endif
                                                </div>
                                            </div>
                                            <span class="font-medium text-sm">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-sm text-base-content/60">{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge badge-sm">{{ $role->label ?? $role->name }}</span>
                                        @empty
                                            <span class="text-xs text-base-content/40">بدون نقش</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                            @csrf
                                            <select name="role_id" class="select select-bordered select-xs" onchange="this.form.submit()">
                                                <option value="">انتخاب نقش</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>
                                                        {{ $role->label ?? $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('مطمئنی؟')">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost btn-xs text-error">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if(isset($users))
                        {{ $users->links() }}
                    @endif
                </div>
            </div>

        @endif

    </div>

    <script>
        document.getElementById('avatarInput').addEventListener('change', function(){
            if(this.files[0]){
                const reader = new FileReader();
                reader.onload = e => {
                    document.querySelector('.avatar img').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</x-layout>

<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body gap-6">
                    <h1 class="text-3xl font-bold text-center mb-6  gap-6">ساخت حساب کاربری</h1>
                    <form novalidate method="POST" action="/register">
                        @csrf

                        <!-- Name -->
                        <label class="floating-label mb-6 w-full flex">
                            <input type="text"
                                   name="name"
                                   placeholder="نام و نام خانوادگی"
                                   value="{{ old('name') }}"
                                   class="input input-bordered w-full @error('name') input-error @enderror"
                                   required>
                            <span>Name</span>
                        </label>
                        @error('name')
                        <div class="label -mt-4 mb-2">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror

                        <!-- Email -->
                        <label class="floating-label mb-6 w-full flex">
                            <input type="email"
                                   name="email"
                                   placeholder="ایمیل"
                                   value="{{ old('email') }}"
                                   class="input input-bordered w-full @error('email') input-error @enderror"
                                   required>
                            <span>Email</span>
                        </label>
                        @error('email')
                        <div class="label -mt-4 mb-2">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror

                        <!-- Password -->
                        <label class="floating-label mb-6 w-full flex">
                            <input type="password"
                                   name="password"
                                   placeholder="پسورد"
                                   class="input input-bordered w-full @error('password') input-error @enderror"
                                   required>
                            <span>Password</span>
                        </label>
                        @error('password')
                        <div class="label -mt-4 mb-2">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                        @enderror

                        <!-- Password Confirmation -->
                        <label class="floating-label mb-6 w-full flex">
                            <input type="password"
                                   name="password_confirmation"
                                   placeholder="تکرار پسورد"
                                   class="input input-bordered w-full"
                                   required>
                            <span>Confirm Password</span>
                        </label>

                        <!-- Submit Button -->
                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary btn-sm w-full">
                                ساخت حساب
                            </button>
                        </div>
                    </form>

                    <div class="divider">یا</div>
                    <p class="text-center text-sm">
                        حساب کاربری دارید؟
                        <a href="{{route('login')}}" class="link link-primary">ورود</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<x-layout title="Coffee Blog">

    {{-- ===== HERO ===== --}}
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col lg:flex-row">
            <div class="hover-3d">
                <figure class="max-w-100 rounded-2xl">
                    <img src="{{ asset('/coffee2.jpg') }}" alt="3D card" />
                </figure>
                <div></div><div></div><div></div><div></div>
                <div></div><div></div><div></div><div></div>
            </div>
            <div>
                <h1 class="text-5xl font-bold">قهوه یک نوشیدنی دلنشین</h1>
                <p class="py-6">
                    قهوه یکی از نوشیدنی‌های محبوب دنیا است که اغلب مردم در ابتدای روز و حین کار
                    به عنوان یک نوشیدنی لذت‌بخش و شادابی‌بخش استفاده می‌کنند
                </p>
                <button class="btn btn-primary">شروع کنید</button>
            </div>
        </div>
    </div>

    {{-- ===== آمار ===== --}}
    <section class="bg-base-100 py-12">
        <div class="max-w-5xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-value text-primary">+۱۲۰</div>
                <div class="stat-desc text-base-content/70 text-sm mt-1">مقاله منتشر شده</div>
            </div>
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-value text-primary">+۵۰</div>
                <div class="stat-desc text-base-content/70 text-sm mt-1">نوع قهوه بررسی شده</div>
            </div>
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-value text-primary">+۸K</div>
                <div class="stat-desc text-base-content/70 text-sm mt-1">خواننده ماهانه</div>
            </div>
            <div class="stat bg-base-200 rounded-box">
                <div class="stat-value text-primary">۴.۹</div>
                <div class="stat-desc text-base-content/70 text-sm mt-1">امتیاز کاربران</div>
            </div>
        </div>
    </section>

    {{-- ===== درباره بلاگ ===== --}}
    <section class="bg-base-200 py-20">
        <div class="max-w-5xl mx-auto px-4 flex flex-col lg:flex-row items-center gap-12">
            <div class="flex-1">
                <span class="badge badge-primary mb-3">درباره ما</span>
                <h2 class="text-4xl font-bold mb-5 leading-snug">
                    چرا این بلاگ را<br>راه‌اندازی کردیم؟
                </h2>
                <p class="text-base-content/70 leading-8 mb-4">
                    ما یک گروه کوچک از علاقه‌مندان به قهوه هستیم که باور داریم هر فنجان قهوه
                    داستانی دارد. از مزرعه تا فنجان، از روش‌های دم‌آوری تا تفاوت انواع برشته‌کاری —
                    اینجا همه چیز را با زبانی ساده توضیح می‌دهیم.
                </p>
                <p class="text-base-content/70 leading-8">
                    هدف ما کمک به علاقه‌مندان تازه‌کار و حرفه‌ای‌هاست تا انتخاب بهتری داشته باشند
                    و لذت بیشتری از قهوه‌شان ببرند.
                </p>
            </div>
            <div class="flex-1 grid grid-cols-2 gap-4">
                <div class="card bg-base-100 shadow-sm p-5">
                    <div class="text-3xl mb-2">☕</div>
                    <h3 class="font-bold mb-1">دم‌آوری</h3>
                    <p class="text-sm text-base-content/60">روش‌های مختلف از اسپرسو تا فرنچ‌پرس</p>
                </div>
                <div class="card bg-base-100 shadow-sm p-5">
                    <div class="text-3xl mb-2">🌱</div>
                    <h3 class="font-bold mb-1">منشأ دانه</h3>
                    <p class="text-sm text-base-content/60">اتیوپی، کلمبیا، برزیل و بیشتر</p>
                </div>
                <div class="card bg-base-100 shadow-sm p-5">
                    <div class="text-3xl mb-2">🔥</div>
                    <h3 class="font-bold mb-1">برشته‌کاری</h3>
                    <p class="text-sm text-base-content/60">تفاوت روست‌های روشن، میانه و تیره</p>
                </div>
                <div class="card bg-base-100 shadow-sm p-5">
                    <div class="text-3xl mb-2">🧪</div>
                    <h3 class="font-bold mb-1">کاپینگ</h3>
                    <p class="text-sm text-base-content/60">چطور طعم قهوه را تشخیص دهیم</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== کاروسل تصاویر ===== --}}
    <section class="bg-base-100 py-20">
        <div class="w-full max-w-xl md:max-w-5xl lg:max-w-7xl mx-auto px-4">
            <div class="text-center mb-10 gap-5">
                <span class="badge badge-primary mb-3">گالری</span>
                <h2 class="text-3xl font-bold">دنیای قهوه در یک نگاه</h2>
            </div>

            <div id="coffeeCarousel" class="carousel rounded-box w-full">

                <div class="carousel-item w-full ">
                    <img src="{{asset('1.jpg')}}" class="w-full h-full object-cover">
                </div>

                <div class="carousel-item w-full">
                    <img src="{{asset('2.jpeg')}}" class="w-full h-full object-cover">
                </div>

                <div class="carousel-item w-full">
                    <img src="{{asset('3.jpg')}}" class="w-full h-full object-cover">
                </div>

                <div class="carousel-item w-full">
                    <img src="{{asset('4.jpg')}}" class="w-full h-full object-cover">
                </div>

            </div>

        </div>
    </section>

    {{-- ===== آخرین مقالات ===== --}}
    <section class="bg-base-200 py-20">
        <div class="max-w-5xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="badge badge-primary mb-2">بلاگ</span>
                    <h2 class="text-3xl font-bold">آخرین مطالب</h2>
                </div>
                <a href="/posts" class="btn btn-outline btn-sm">همه مقالات</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- کارت نمونه — با @foreach از دیتابیس جایگزین کن --}}
                @foreach([
                    ['title' => 'تفاوت اسپرسو و فیلتر کافی چیست؟', 'cat' => 'دم‌آوری', 'min' => '۵'],
                    ['title' => 'بهترین قهوه‌های تک‌خاستگاه اتیوپی', 'cat' => 'معرفی', 'min' => '۸'],
                    ['title' => 'راهنمای خرید آسیاب قهوه خانگی', 'cat' => 'تجهیزات', 'min' => '۶'],
                ] as $post)
                    <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-40 bg-base-300 rounded-t-2xl flex items-center justify-center text-5xl">☕</div>
                        <div class="card-body">
                            <span class="badge badge-ghost badge-sm">{{ $post['cat'] }}</span>
                            <h3 class="card-title text-base leading-snug mt-1">{{ $post['title'] }}</h3>
                            <div class="card-actions items-center justify-between mt-2">
                                <span class="text-xs text-base-content/50">{{ $post['min'] }} دقیقه مطالعه</span>
                                <a href="#" class="btn btn-primary btn-xs">بخوانید</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== خبرنامه ===== --}}
    <section class="bg-primary text-primary-content py-16">
        <div class="max-w-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-3">در جریان باشید</h2>
            <p class="mb-6 opacity-80">هر هفته یک مقاله ناب درباره قهوه مستقیم توی ایمیلتان</p>
            <div class="flex gap-2 justify-center">
                <input type="email" placeholder="ایمیل شما..."
                       class="input input-bordered bg-primary-content/10 text-primary-content placeholder:text-primary-content/50 w-64">
                <button class="btn bg-primary-content text-primary hover:bg-primary-content/90">عضویت</button>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer sm:footer-horizontal bg-neutral text-neutral-content items-center p-4">
        <aside class="grid-flow-col items-center">
            <svg width="36" height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                 fill-rule="evenodd" clip-rule="evenodd" class="fill-current">
                <path d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z"/>
            </svg>
            <p>حق نشر محفوظ است {{ date('Y') }}</p>
            <div></div>

        </aside>
        <nav class="grid-flow-col gap-4 md:place-self-center md:justify-self-end">
            <p>دانشجوی کامپیوتر هستم و شما طراحی های من رو نگاه میکنید</p>
            <a href="#" aria-label="Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                </svg>
            </a>
            <a href="#" aria-label="YouTube">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                </svg>
            </a>
            <a href="#" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                </svg>
            </a>
        </nav>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const carousel = document.getElementById("coffeeCarousel");
            if (!carousel) return;

            const items = carousel.querySelectorAll(".carousel-item");
            let index = 0;

            setInterval(() => {
                index++;

                if (index >= items.length) {
                    index = 0;
                }

                const item = items[index];

                const left = item.offsetLeft;

                carousel.scrollTo({
                    left: left,
                    behavior: "smooth"
                });

            }, 3000);
        });
    </script>

</x-layout>

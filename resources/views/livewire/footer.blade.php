<footer
    class="w-full  dark:bg-gray-900 transition-colors duration-200 text-gray-700 dark:text-gray-300 py-12">
    <div class="container mx-auto px-6 md:px-12 lg:px-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">

            <!-- Logo & Description -->
            <section aria-labelledby="footer-brand" class="space-y-4">
                <div class="flex items-center space-x-4">
                    @if ($shopInfo->url_logo)
                        <img src="{{ Storage::url($shopInfo->url_logo) }}" alt="{{ $shopInfo->name }} Logo"
                            class="h-12 w-12 rounded-md object-contain shadow" />
                    @endif
                    <h2 id="footer-brand" class="text-xl font-bold text-gray-900 dark:text-white">{{ $shopInfo->name }}
                    </h2>
                </div>
                <p class="text-sm text-muted-foreground dark:text-gray-400">
                    {{ $shopInfo->description }}
                </p>
            </section>

            <!-- Contact Information -->
            <section aria-labelledby="footer-contact" class="space-y-4">
                <h3 id="footer-contact" class="text-lg font-semibold">Kontak Kami</h3>
                <address class="space-y-3 text-sm not-italic">
                    <div class="flex items-start space-x-3">
                        <svg class="h-5 w-5 text-primary mt-0.5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M21 10c0 6-9 12-9 12S3 16 3 10a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span>{{ $shopInfo->address }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M22 16.92v3a2 2 0 01-2.18 2A19.8 19.8 0 013 5.18 2 2 0 015 3h3a2 2 0 012 1.72 12.05 12.05 0 005.1 7.42A2 2 0 0116 13v3a2 2 0 01-1.72 2z" />
                        </svg>
                        <a href="tel:{{ $shopInfo->phone }}" class="hover:underline">{{ $shopInfo->phone }}</a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M4 4h16v16H4z" />
                            <path d="M22 6l-10 7L2 6" />
                        </svg>
                        <a href="mailto:{{ $shopInfo->email }}" class="hover:underline">{{ $shopInfo->email }}</a>
                    </div>
                </address>
            </section>

            <!-- Social Media & Newsletter -->
            <nav aria-labelledby="footer-social" class="space-y-4">
                <h3 id="footer-social" class="text-lg font-semibold">Ikuti Kami</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach ($shopInfo->socialMedia as $social)
                        @if ($social->is_active)
                            <a href="{{ Storage::url($social->url) }}" target="_blank"
                                aria-label="{{ ucfirst($social->url) }}">
                                <img src="{{ Storage::url($social->icon) }}" alt="{{ $social->icon }}"
                                    class="object-contain w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors" />
                            </a>
                        @endif
                    @endforeach
                </div>
            </nav>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm">
                {{ date('Y') }} <span
                    class="font-semibold text-gray-900 dark:text-white">{{ $shopInfo->name }}</span>
            </p>
        </div>
    </div>
</footer>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoType = 'page';
        $seoKey = null;
        $routeName = request()->route()?->getName();

        if (request()->routeIs('website.blog-details') || request()->is('blog/*') || request()->is('blog-details') || request()->is('blog-details.php')) {
            $seoType = 'blog';
            $seoKey = request()->route('slug') ?: request('post');
        } elseif ($routeName && str_starts_with($routeName, 'website.')) {
            $seoKey = str_replace('website.', '', $routeName);
        } else {
            $seoKey = trim(request()->path(), '/') ?: 'index';
            $seoKey = str_replace('.php', '', $seoKey);
        }

        $seoMeta = $seoMeta ?? ($seoKey ? \App\Models\SeoMetaTag::findActive($seoType, $seoKey) : null);
        $globalScripts = \App\Models\GlobalScript::findCurrent();
        $metaTitle = $seoMeta?->meta_title ?: ($pageTitle ?? 'Fond Travels Clone');
        $metaDescription = $seoMeta?->meta_description ?: ($pageDescription ?? 'Explore and book flights, hotels, and holiday destinations around the world.');
        $metaKeywords = $seoMeta?->meta_keywords;
        $canonicalUrl = $seoMeta?->canonical_url ?: url()->current();
        $ogTitle = $seoMeta?->og_title ?: $metaTitle;
        $ogDescription = $seoMeta?->og_description ?: $metaDescription;
        $ogImage = $seoMeta?->og_image;
    @endphp

    <title>{{ $metaTitle }}</title>

    <meta name="description" content="{{ $metaDescription }}">
    @if ($metaKeywords)
        <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <!-- CSS Stylesheets -->
    <link href="{{ asset('dashboardAssets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboardAssets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    @foreach ($extraCSS ?? [] as $cssFile)
        @php
            $cssFile = ltrim($cssFile, '/');
            $cssHref = preg_match('#^(https?:)?//#', $cssFile)
                ? $cssFile
                : asset(str_starts_with($cssFile, 'assets/') ? $cssFile : 'assets/' . $cssFile);
        @endphp
        <link rel="stylesheet" href="{{ $cssHref }}">
    @endforeach
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if (filled($globalScripts?->header_scripts))
        {!! $globalScripts->header_scripts !!}
    @endif
</head>

<body>
    @if (filled($globalScripts?->body_scripts))
        {!! $globalScripts->body_scripts !!}
    @endif

    <!-- App Container -->
    <div id="app">
        <!-- Header Section -->
        <header class="main-header">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="container top-bar-container">
                    <div class="top-bar-left">
                        <span class="support-badge">
                            <span class="pulse-dot"></span>
                            Customer Support 24/7
                        </span>
                        <div class="social-icons">
                            <a href="#" aria-label="Facebook" class="social-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z" />
                                </svg>
                            </a>
                            <a href="#" aria-label="Twitter" class="social-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#" aria-label="Instagram" class="social-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="top-bar-right">
                        <a href="tel:+13238006001" class="support-phone">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"
                                class="phone-icon">
                                <path
                                    d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-2.2 2.2a15.045 15.045 0 01-6.59-6.59l2.2-2.21a.96.96 0 00.25-1A11.36 11.36 0 018.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
                            </svg>
                            <span class="phone-label">Toll-Free Support:</span>
                            <span class="phone-number">+1 (323) 800-6001</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Navigation Bar -->
            <div class="navbar">
                <div class="container navbar-container">
                    <!-- Brand Logo -->
                    <a href="{{ url('/') }}" class="logo" aria-label="Fond Travels Home">
                        <span class="logo-bold">Fond</span><span class="logo-light">Travels</span>
                        <svg class="logo-plane" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path
                                d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L14 19v-5.5l7 2.5z" />
                        </svg>
                    </a>

                    <!-- Desktop Navigation Menu -->
                    @php
                        $activeClass = fn(...$routes) => request()->routeIs(...$routes) ? 'active' : '';
                    @endphp
                    <nav class="nav-menu" aria-label="Main Navigation">
                        <ul class="nav-list">
                            <li><a href="{{ route('website.flights') }}"
                                    class="nav-link {{ $activeClass('website.flights') }}">Flights</a></li>
                            <li><a href="{{ route('website.hotels') }}"
                                    class="nav-link {{ $activeClass('website.hotels') }}">Hotels</a></li>
                            <li><a href="{{ route('website.cars') }}"
                                    class="nav-link {{ $activeClass('website.cars') }}">Cars</a></li>
                            <li><a href="{{ route('website.packages') }}"
                                    class="nav-link {{ $activeClass('website.packages', 'website.package-details') }}">Packages</a>
                            </li>
                            <li><a href="{{ route('website.about') }}"
                                    class="nav-link {{ $activeClass('website.about') }}">About
                                    Us</a></li>
                            <li><a href="{{ route('website.blog') }}"
                                    class="nav-link {{ $activeClass('website.blog', 'website.blog-details') }}">Blogs</a>
                            </li>
                            <li><a href="{{ route('website.contact') }}"
                                    class="nav-link {{ $activeClass('website.contact') }}">Contact</a></li>
                        </ul>
                    </nav>

                    <!-- Right Action Area -->
                    <div class="nav-actions">
                        <a href="tel:+13238006001" class="btn btn-call" aria-label="Call Fond Travels">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                <path
                                    d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-2.2 2.2a15.045 15.045 0 01-6.59-6.59l2.2-2.21a.96.96 0 00.25-1A11.36 11.36 0 018.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
                            </svg>
                            <span>Book Now</span>
                        </a>
                        <button class="mobile-toggle" aria-label="Toggle Navigation Menu" aria-expanded="false"
                            aria-controls="mobile-nav">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer Menu -->
            <div class="mobile-drawer" id="mobile-nav" aria-hidden="true">
                <div class="drawer-header">
                    <a href="{{ url('/') }}" class="logo" aria-label="Fond Travels Home">
                        <span class="logo-bold">Fond</span><span class="logo-light">Travels</span>
                    </a>
                    <button class="drawer-close" aria-label="Close Navigation Menu">
                        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path
                                d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                        </svg>
                    </button>
                </div>
                <nav class="drawer-menu" aria-label="Mobile Navigation">
                    <ul class="drawer-list">
                        <li><a href="{{ route('website.flights') }}"
                                class="drawer-link {{ $activeClass('website.flights') }}">Flights</a></li>
                        <li><a href="{{ route('website.hotels') }}"
                                class="drawer-link {{ $activeClass('website.hotels') }}">Hotels</a></li>
                        <li><a href="{{ route('website.cars') }}"
                                class="drawer-link {{ $activeClass('website.cars') }}">Cars</a></li>
                        <li><a href="{{ route('website.packages') }}"
                                class="drawer-link {{ $activeClass('website.packages', 'website.package-details') }}">Packages</a>
                        </li>
                        <li><a href="{{ route('website.about') }}"
                                class="drawer-link {{ $activeClass('website.about') }}">About Us</a></li>
                        <li><a href="{{ route('website.blog') }}"
                                class="drawer-link {{ $activeClass('website.blog', 'website.blog-details') }}">Blogs</a>
                        </li>
                        <li><a href="{{ route('website.contact') }}"
                                class="drawer-link {{ $activeClass('website.contact') }}">Contact</a></li>
                    </ul>
                </nav>
                <div class="drawer-footer">
                    <a href="tel:+13238006001" class="drawer-phone">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path
                                d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-2.2 2.2a15.045 15.045 0 01-6.59-6.59l2.2-2.21a.96.96 0 00.25-1A11.36 11.36 0 018.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
                        </svg>
                        <span>+1 (323) 800-6001</span>
                    </a>
                    <p class="drawer-support-label">24/7 Travel Assistance Toll-Free</p>
                </div>
            </div>
            <div class="drawer-overlay"></div>
        </header>

        {{ $slot }}

        <!-- Footer Section -->
        <footer class="main-footer" id="footer" role="contentinfo">
            <!-- Top Footer -->
            <div class="footer-top">
                <div class="container">
                    <div class="footer-grid">
                        <!-- Col 1: Popular Routes -->
                        <div class="footer-col">
                            <h4 class="footer-col-title">Popular Routes</h4>
                            <ul class="footer-links">
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from New
                                        York</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from Los
                                        Angeles</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from
                                        Chicago</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from
                                        Miami</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from
                                        Houston</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Flights from
                                        Dallas</a></li>
                            </ul>
                        </div>
                        <!-- Col 2: Airlines -->
                        <div class="footer-col">
                            <h4 class="footer-col-title">Airlines</h4>
                            <ul class="footer-links">
                                <li><a href="{{ route('website.flights') }}" class="footer-link">American
                                        Airlines</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Delta Air Lines</a>
                                </li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">United Airlines</a>
                                </li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">British Airways</a>
                                </li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Lufthansa</a></li>
                                <li><a href="{{ route('website.flights') }}" class="footer-link">Emirates
                                        Airlines</a></li>
                            </ul>
                        </div>
                        <!-- Col 3: Company -->
                        <div class="footer-col">
                            <h4 class="footer-col-title">Company</h4>
                            <ul class="footer-links">
                                <li><a href="{{ route('website.about') }}" class="footer-link">About Us</a></li>
                                <li><a href="{{ route('website.contact') }}" class="footer-link">Contact Us</a></li>
                                <li><a href="{{ route('website.index') }}#blog" class="footer-link">Travel Blog</a>
                                </li>
                                <li><a href="{{ route('website.privacy-policy') }}" class="footer-link">Privacy
                                        Policy</a></li>
                                <li><a href="{{ route('website.terms') }}" class="footer-link">Terms &amp;
                                        Conditions</a></li>
                                <li><a href="{{ asset('sitemap.xml') }}" class="footer-link">Sitemap</a></li>
                            </ul>
                        </div>
                        <!-- Col 4: Newsletter -->
                        <div class="footer-col">
                            <h4 class="footer-col-title">Newsletter</h4>
                            <p class="newsletter-desc">Subscribe and get exclusive flight deals, travel guides, and
                                tips delivered to your inbox.</p>
                            <div class="newsletter-form">
                                <div class="newsletter-input-group">
                                    <input type="email" class="newsletter-input" placeholder="Your email address"
                                        aria-label="Email for newsletter">
                                    <button class="newsletter-btn" type="button">Subscribe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Middle: Contact -->
            <div class="footer-middle">
                <div class="container">
                    <div class="footer-contact-row">
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                    <path
                                        d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-2.2 2.2a15.045 15.045 0 01-6.59-6.59l2.2-2.21a.96.96 0 00.25-1A11.36 11.36 0 018.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
                                </svg>
                            </div>
                            <div>
                                <span class="footer-contact-label">Toll-Free Support</span>
                                <a href="tel:+13238006001" class="footer-contact-value">+1 (323) 800-6001</a>
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                    <path
                                        d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="footer-contact-label">Email Support</span>
                                <a href="mailto:support@fondtravels.com"
                                    class="footer-contact-value">support@fondtravels.com</a>
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <div class="footer-contact-icon">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                                    <path
                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                            </div>
                            <div>
                                <span class="footer-contact-label">Headquarters</span>
                                <span class="footer-contact-value">Los Angeles, CA, USA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="footer-bottom-row">
                        <p class="footer-copyright">&copy; 2026 <strong>Fond Travels</strong>. All rights reserved.</p>
                        <!-- Payment Icons -->
                        <div class="payment-icons" aria-label="Accepted payment methods">
                            <div class="payment-icon"><span>VISA</span></div>
                            <div class="payment-icon"><span>Mastercard</span></div>
                            <div class="payment-icon"><span>Amex</span></div>
                            <div class="payment-icon"><span>Discover</span></div>
                        </div>
                        <!-- Social Links -->
                        <div class="footer-social">
                            <a href="#" class="footer-social-link" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z" />
                                </svg>
                            </a>
                            <a href="#" class="footer-social-link" aria-label="Twitter">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#" class="footer-social-link" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Sticky Bottom CTA Banner -->
        <div class="sticky-bottom-cta" id="stickyCtaBanner">
            <div class="cta-capsule">
                <div class="cta-avatar">
                    <img src="{{ asset('assets/images/support-agent.png') }}" alt="Support Agent">
                </div>
                <div class="cta-text-content">
                    <div class="cta-heading">Better Deals, Just a Call Away</div>
                    <div class="cta-subheading">
                        <span class="phone-number">1-646-738-4832</span>
                        <span class="promo-text">Call and say <strong class="orange-text">DIAL10</strong> to
                            save.</span>
                        <span class="info-icon" title="Terms & conditions apply">ℹ</span>
                    </div>
                </div>
                <a href="tel:+16467384832" class="cta-call-btn">Call us</a>
                <button type="button" class="cta-close-btn" id="closeCtaBtn"
                    aria-label="Collapse support call banner">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Collapsed Floating CTA Button -->
        <button type="button" class="cta-floating-trigger" id="ctaFloatingTrigger" style="display: none;">
            <div class="floating-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path
                        d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-2.2 2.2a15.045 15.045 0 01-6.59-6.59l2.2-2.21a.96.96 0 00.25-1A11.36 11.36 0 018.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
                </svg>
            </div>
            <span class="floating-text">Call Us</span>
        </button>

        <script src="{{ asset('dashboardAssets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('dashboardAssets/js/main.js') }}"></script>

        <script>
            // Run immediately during parsing to prevent flash of wrong state (FOUC)
            if (sessionStorage.getItem('cta-state') === 'collapsed') {
                document.getElementById('stickyCtaBanner').style.display = 'none';
                var trigger = document.getElementById('ctaFloatingTrigger');
                trigger.style.display = 'flex';
                trigger.classList.add('visible');
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctaBanner = document.getElementById('stickyCtaBanner');
                var closeCtaBtn = document.getElementById('closeCtaBtn');
                var floatingTrigger = document.getElementById('ctaFloatingTrigger');

                if (ctaBanner && floatingTrigger) {
                    var savedState = sessionStorage.getItem('cta-state');

                    // Dom ready state check (handles cases where parsing script was bypassed or for extra safety)
                    if (savedState === 'collapsed') {
                        ctaBanner.style.display = 'none';
                        floatingTrigger.style.display = 'flex';
                        floatingTrigger.classList.add('visible');
                    } else {
                        ctaBanner.style.display = 'block';
                        floatingTrigger.style.display = 'none';
                    }

                    if (closeCtaBtn) {
                        closeCtaBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            // Collapse banner
                            ctaBanner.classList.add('hiding');
                            sessionStorage.setItem('cta-state', 'collapsed');

                            // Show floating trigger
                            floatingTrigger.style.display = 'flex';
                            setTimeout(function() {
                                floatingTrigger.classList.add('visible');
                            }, 50);

                            setTimeout(function() {
                                ctaBanner.style.display = 'none';
                                ctaBanner.classList.remove('hiding');
                            }, 400);
                        });
                    }

                    floatingTrigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Hide floating trigger
                        floatingTrigger.classList.remove('visible');
                        sessionStorage.setItem('cta-state', 'expanded');

                        // Expand banner
                        ctaBanner.style.display = 'block';
                        ctaBanner.classList.add('expanding');

                        setTimeout(function() {
                            floatingTrigger.style.display = 'none';
                            ctaBanner.classList.remove('expanding');
                        }, 400);
                    });
                }
            });
        </script>

        <!-- JS Scripts -->
        <script
            src="{{ asset('assets/js/header.js') }}?v={{ file_exists(public_path('assets/js/header.js')) ? filemtime(public_path('assets/js/header.js')) : time() }}"
            defer></script>
        @foreach ($extraJS ?? [] as $jsFile)
            @php
                $jsFile = ltrim($jsFile, '/');
                $jsAssetPath = str_starts_with($jsFile, 'assets/') ? $jsFile : 'assets/' . $jsFile;
                $jsSrc = preg_match('#^(https?:)?//#', $jsFile) ? $jsFile : asset($jsAssetPath);
                $jsVersion = file_exists(public_path($jsAssetPath)) ? filemtime(public_path($jsAssetPath)) : time();
            @endphp
            <script src="{{ $jsSrc }}?v={{ $jsVersion }}" defer></script>
        @endforeach
        @if (filled($globalScripts?->footer_scripts))
            {!! $globalScripts->footer_scripts !!}
        @endif
</body>

</html>

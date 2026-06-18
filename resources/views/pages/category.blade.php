@extends('layouts.app')

@push('seo')
    <meta name="description" content="Browse and compare {{ $category->name }} with AI-driven benchmarks and real-world efficiency scores."/>
@endpush

@section('title', $category->name . ' | SpecWise AI')

@section('content')
<main class="pt-24 pb-20 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <!-- Breadcrumbs & Header -->
    <section class="mb-12">
        <nav class="flex items-center gap-2 text-on-surface-variant font-label-caps text-label-caps mb-4">
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->last)
                    <a class="hover:text-primary" href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                @else
                    <span class="text-primary font-bold">{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-background tracking-tight">{{ $category->name }}</h1>
                <p class="text-on-surface-variant font-body-lg text-body-lg max-w-2xl">Compare the world's most powerful {{ strtolower($category->name) }} with AI-driven benchmarks and real-world efficiency scores.</p>
            </div>
        </div>
    </section>

    <!-- Top Rated Widget (Carousel / Dynamic Highlights) -->
    <section class="mb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-headline-md text-headline-md flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">stars</span>
                AI Top Picks
            </h2>
            <div class="flex gap-2">
                <button id="slide-left" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:bg-surface-variant transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <button id="slide-right" class="w-10 h-10 rounded-full border border-outline-variant flex items-center justify-center hover:bg-surface-variant transition-colors">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>
        <div id="carousel-container" class="flex gap-gutter overflow-x-auto pb-6 custom-scrollbar scroll-smooth">
            @foreach($products->take(3) as $prod)
            <div class="min-w-[320px] md:min-w-[400px] glass p-6 rounded-xl flex-shrink-0 bg-white border border-black/5 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-secondary-container text-on-secondary-container font-label-caps text-label-caps px-3 py-1 rounded-full text-white bg-secondary">TOP PICK</span>
                    <div class="flex items-center gap-1 text-primary font-bold">
                        <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bolt</span>
                        {{ 85 + $loop->index * 4 }}/100
                    </div>
                </div>
                <div class="aspect-video w-full mb-6 rounded-lg overflow-hidden bg-white p-4 flex items-center justify-center border border-black/5">
                    <img class="w-full h-full object-contain" src="{{ $prod->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $prod->name }}"/>
                </div>
                <h3 class="font-headline-md text-headline-md mb-1">{{ $prod->name }}</h3>
                <p class="text-on-surface-variant text-body-md mb-4">{{ $prod->brand }} • ${{ number_format($prod->lowest_price ?? 0, 2) }}</p>
                <a href="{{ route('products.show', $prod->slug) }}" class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 rounded-lg font-bold flex items-center justify-center gap-2 group overflow-hidden relative active:scale-95 transition-all text-center">
                    <span>Compare Specs</span>
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            @endforeach
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="md:col-span-3 space-y-8">
            <form action="{{ route('categories.show', $category->slug) }}" method="GET" id="category-filter-form">
                <div>
                    <h4 class="font-bold text-on-background mb-4 flex items-center justify-between">
                        Brands
                        <span class="material-symbols-outlined text-outline font-normal">expand_less</span>
                    </h4>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="brand" value="" {{ !request('brand') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline text-primary focus:ring-primary"/>
                            <span class="text-on-surface-variant group-hover:text-primary transition-colors">All Brands</span>
                        </label>
                        @foreach($brands as $b)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio" name="brand" value="{{ $b }}" {{ request('brand') === $b ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline text-primary focus:ring-primary"/>
                            <span class="text-on-surface-variant group-hover:text-primary transition-colors">{{ $b }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </form>
        </aside>

        <!-- Main Product Grid -->
        <div class="md:col-span-9">
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-black/5 shadow-sm px-6">
                    <span class="material-symbols-outlined text-[64px] text-primary/40 mb-4">search_off</span>
                    <h2 class="font-headline-md text-on-surface mb-2">No Products</h2>
                    <p class="text-on-surface-variant">No products found in this category matching your filters.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $prod)
                    <div class="glass rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 group bg-white border border-black/5 flex flex-col justify-between h-full">
                        <div>
                            <div class="h-48 relative p-4 bg-white flex items-center justify-center">
                                <img class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500" src="{{ $prod->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $prod->name }}"/>
                            </div>
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <h3 class="font-bold text-on-background group-hover:text-primary transition-colors">{{ $prod->name }}</h3>
                                    <span class="font-mono-data text-primary shrink-0">${{ number_format($prod->lowest_price ?? 0, 2) }}</span>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="text-label-caps text-[10px] bg-surface-container px-2 py-0.5 rounded uppercase">{{ $prod->brand }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 pb-5">
                            <a href="{{ route('products.show', $prod->slug) }}" class="w-full block text-center py-2 bg-surface-container-high rounded-lg text-on-surface font-bold text-sm hover:bg-primary hover:text-white transition-all">View Specs</a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.getElementById('carousel-container');
        document.getElementById('slide-right').addEventListener('click', () => {
            carousel.scrollBy({ left: 350, behavior: 'smooth' });
        });
        document.getElementById('slide-left').addEventListener('click', () => {
            carousel.scrollBy({ left: -350, behavior: 'smooth' });
        });
    });
</script>
@endpush

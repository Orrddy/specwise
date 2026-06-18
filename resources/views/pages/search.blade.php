@extends('layouts.app')

@push('seo')
    <meta name="description" content="AI Search Results for your tech spec comparison queries. Find, filter, and compare devices with ease."/>
@endpush

@section('title', 'SpecWise | AI Search Results')

@section('content')
<main class="pt-32 pb-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <!-- Header & Query -->
    <header class="mb-12">
        <div class="flex items-center gap-3 mb-4 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
            <span class="font-label-caps text-label-caps tracking-widest uppercase">Natural Language Query</span>
        </div>
        <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface leading-tight mb-8">
            "{{ $query ?: 'Search all products' }}"
        </h1>
        <!-- AI Intent Box -->
        <div class="ai-glow glass rounded-xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/50 backdrop-blur-md">
            <div class="flex items-start gap-4">
                <div class="bg-primary-container text-on-primary-container p-3 rounded-lg text-white">
                    <span class="material-symbols-outlined">psychology</span>
                </div>
                <div>
                    <p class="font-headline-md text-headline-md text-on-surface">AI Interpretation</p>
                    <p class="text-on-surface-variant">Filtering products across categories for keywords: <span class="text-primary font-semibold italic">{{ $query ?: 'None' }}</span>.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @if(request('category'))
                    <span class="bg-surface-container-highest text-on-surface-variant px-3 py-1 rounded-full text-xs font-semibold border border-outline-variant/20">Category: {{ request('category') }}</span>
                @endif
                @if(request('brand'))
                    <span class="bg-surface-container-highest text-on-surface-variant px-3 py-1 rounded-full text-xs font-semibold border border-outline-variant/20">Brand: {{ request('brand') }}</span>
                @endif
            </div>
        </div>
    </header>

    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 shrink-0 space-y-8">
            <form action="{{ route('search') }}" method="GET" id="filter-form">
                <input type="hidden" name="q" value="{{ $query }}"/>
                <div>
                    <h3 class="font-headline-md text-body-lg font-bold mb-4 flex items-center justify-between">
                        Filters
                        <span class="material-symbols-outlined text-outline">tune</span>
                    </h3>
                    <div class="space-y-6">
                        <!-- Category Filter -->
                        <section>
                            <p class="font-label-caps text-label-caps mb-3 text-outline">CATEGORY</p>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline-variant text-primary focus:ring-primary"/>
                                    <span class="text-body-md text-on-surface-variant">All Categories</span>
                                </label>
                                @foreach($categories as $cat)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline-variant text-primary focus:ring-primary"/>
                                    <span class="text-body-md text-on-surface-variant">{{ $cat->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </section>

                        <!-- Brand Filter -->
                        <section>
                            <p class="font-label-caps text-label-caps mb-3 text-outline">BRAND</p>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="brand" value="" {{ !request('brand') ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline-variant text-primary focus:ring-primary"/>
                                    <span class="text-body-md text-on-surface-variant">All Brands</span>
                                </label>
                                @foreach($brands as $b)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" name="brand" value="{{ $b }}" {{ request('brand') === $b ? 'checked' : '' }} onchange="this.form.submit()" class="rounded-full border-outline-variant text-primary focus:ring-primary"/>
                                    <span class="text-body-md text-on-surface-variant">{{ $b }}</span>
                                </label>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <p class="text-body-md text-on-surface-variant">Showing <span class="font-bold text-on-surface">{{ $products->total() }} results</span> for your query</p>
            </div>
            
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-black/5 shadow-sm px-6">
                    <span class="material-symbols-outlined text-[64px] text-primary/40 mb-4">search_off</span>
                    <h2 class="font-headline-md text-on-surface mb-2">No Results Found</h2>
                    <p class="text-on-surface-variant">Try adjusting your keywords or filters.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $prod)
                    <div class="glass rounded-2xl overflow-hidden group transition-all duration-300 hover:-translate-y-1 bg-white flex flex-col justify-between h-full border border-black/5 shadow-sm">
                        <div>
                            <div class="relative h-56 w-full p-4 bg-white flex items-center justify-center">
                                <img class="w-full h-full object-contain" src="{{ $prod->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $prod->name }}"/>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <a href="{{ route('products.show', $prod->slug) }}" class="font-headline-md text-headline-md hover:text-primary transition-colors">{{ $prod->name }}</a>
                                    <p class="font-mono-data text-primary font-bold text-lg shrink-0">${{ number_format($prod->lowest_price ?? 0, 2) }}</p>
                                </div>
                                <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">{{ $prod->description }}</p>
                            </div>
                        </div>
                        <div class="px-6 pb-6">
                            <a href="{{ route('products.show', $prod->slug) }}" class="w-full block text-center py-3 rounded-xl border border-primary text-primary font-bold hover:bg-primary hover:text-white transition-all duration-300">View Specs & Analysis</a>
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

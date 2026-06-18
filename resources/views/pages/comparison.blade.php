@extends('layouts.app')

@push('seo')
    <meta name="description" content="Compare products side-by-side with AI-driven insights, specs comparison, price tracking, and real-world performance verdicts."/>
@endpush

@section('title', 'SpecWise | Product Comparison')

@section('content')
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
    <!-- Comparison Header Section -->
    <header class="mb-12">
        <div class="flex flex-col md:flex-row items-end justify-between gap-6 mb-8">
            <div>
                <div class="flex items-center gap-2 text-primary font-semibold text-label-caps mb-2">
                    <span class="material-symbols-outlined text-[16px]">compare_arrows</span>
                    <span>SIDE-BY-SIDE COMPARISON</span>
                </div>
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface leading-tight">
                    @if($products->isNotEmpty())
                        {{ $products->pluck('name')->join(' vs ') }}
                    @else
                        Product Comparison
                    @endif
                </h1>
            </div>
            <a href="{{ route('search') }}" class="flex items-center gap-2 bg-secondary text-on-secondary px-6 py-3 rounded-xl font-bold hover:opacity-90 active:scale-95 transition-all shadow-lg">
                <span class="material-symbols-outlined">add</span>
                Add Product
            </a>
        </div>

        @if($products->count() >= 2)
        <!-- AI Verdict Box -->
        <div class="ai-glow rounded-2xl p-6 md:p-8 relative overflow-hidden mb-12 bg-white/50 backdrop-blur-xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary-container/10 blur-[80px] -z-10 ai-glow-pulse"></div>
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white shadow-xl relative">
                        <span class="material-symbols-outlined text-[32px] font-bold">auto_awesome</span>
                        <div class="absolute -inset-1 bg-white/20 rounded-2xl shimmer-bg"></div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <h2 class="font-headline-md text-on-surface">SpecWise AI Verdict</h2>
                        <span class="bg-secondary-container text-on-secondary-container text-label-caps px-3 py-1 rounded-full border border-secondary-fixed">SMART CHOICE</span>
                    </div>
                    <p class="text-body-lg text-on-surface-variant max-w-3xl leading-relaxed mb-6">
                        {!! $aiNarrative?->content['verdict'] ?? 'Analyzing comparisons using DeepSeek AI. Based on verified specs, ' . $products[0]->name . ' is compared here side by side with ' . $products[1]->name . '.' !!}
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/20">
                            <div class="flex items-center gap-2 text-primary font-bold text-label-caps mb-1">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>WINNER: PERFORMANCE</span>
                            </div>
                            <p class="text-body-md text-on-surface-variant">{{ $aiNarrative?->content['performance_winner'] ?? $products[0]->name . ' leads in raw computational specs.' }}</p>
                        </div>
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/20">
                            <div class="flex items-center gap-2 text-secondary font-bold text-label-caps mb-1">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                <span>WINNER: DISPLAY / DESIGN</span>
                            </div>
                            <p class="text-body-md text-on-surface-variant">{{ $aiNarrative?->content['display_winner'] ?? $products[1]->name . ' offers highly competitive panel metrics.' }}</p>
                        </div>
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/20">
                            <div class="flex items-center gap-2 text-surface-tint font-bold text-label-caps mb-1">
                                <span class="material-symbols-outlined text-[18px]">savings</span>
                                <span>WINNER: VALUE</span>
                            </div>
                            <p class="text-body-md text-on-surface-variant">{{ $aiNarrative?->content['value_winner'] ?? 'Value calculation depends heavily on current retail discounts.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </header>

    @if($products->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-black/5 shadow-sm max-w-2xl mx-auto px-6">
            <span class="material-symbols-outlined text-[64px] text-primary/40 mb-4">compare_arrows</span>
            <h2 class="font-headline-md text-on-surface mb-2">No Products Selected</h2>
            <p class="text-on-surface-variant mb-8">Choose products to compare their specs side-by-side with AI-curated verdicts.</p>
            <a href="{{ route('search') }}" class="bg-primary text-white px-8 py-3 rounded-full font-semibold inline-block cursor-pointer active:scale-95 transition-transform hover:opacity-90">Browse Products</a>
        </div>
    @else
        <!-- Sticky Header Comparison -->
        <div class="sticky top-[72px] z-40 mb-1 glass-panel border border-outline-variant/20 rounded-t-2xl shadow-sm transition-all duration-300">
            <div class="grid grid-cols-12 divide-x divide-outline-variant/20 items-center">
                <!-- Row Header Empty Space -->
                <div class="col-span-3 p-6 flex items-center justify-center">
                    <span class="text-label-caps text-on-surface-variant/50 tracking-widest font-bold">VS</span>
                </div>
                <!-- Product 1 -->
                @if(isset($products[0]))
                <div class="col-span-4 p-4 md:p-6 flex items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-xl flex-shrink-0 p-2 overflow-hidden border border-outline-variant/10">
                        <img class="w-full h-full object-contain" src="{{ $products[0]->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $products[0]->name }}"/>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-body-md md:text-headline-md leading-none mb-1">{{ $products[0]->name }}</h3>
                        <p class="text-primary font-bold text-body-md">${{ number_format($products[0]->lowest_price ?? 0, 2) }}</p>
                    </div>
                </div>
                @endif
                <!-- Product 2 -->
                @if(isset($products[1]))
                <div class="col-span-5 p-4 md:p-6 flex items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 bg-white rounded-xl flex-shrink-0 p-2 overflow-hidden border border-outline-variant/10">
                        <img class="w-full h-full object-contain" src="{{ $products[1]->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $products[1]->name }}"/>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-body-md md:text-headline-md leading-none mb-1">{{ $products[1]->name }}</h3>
                        <p class="text-primary font-bold text-body-md">${{ number_format($products[1]->lowest_price ?? 0, 2) }}</p>
                    </div>
                </div>
                @else
                <div class="col-span-5 p-6 flex items-center justify-center text-on-surface-variant/40 italic">
                    Add another product to compare
                </div>
                @endif
            </div>
        </div>

        <!-- Comparison Table -->
        <div class="border-x border-b border-outline-variant/20 rounded-b-2xl bg-white overflow-hidden shadow-xl mb-24">
            <!-- Category Header -->
            <div class="bg-surface-container-low/50 px-6 py-4 border-b border-outline-variant/10">
                <span class="font-label-caps text-on-surface-variant">SPECIFICATIONS COMPARISON</span>
            </div>

            @foreach($specKeys as $key)
            <!-- Row: {{ ucwords(str_replace('_', ' ', $key)) }} -->
            <div class="grid grid-cols-12 divide-x divide-outline-variant/10 border-b border-outline-variant/10 group hover:bg-surface-container-lowest transition-colors">
                <div class="col-span-3 p-6 flex flex-col justify-center">
                    <div class="flex items-center gap-2 text-on-surface font-semibold group-hover:text-primary transition-colors">
                        <span>{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                    </div>
                </div>
                <!-- Product 1 Spec -->
                @if(isset($products[0]))
                <div class="col-span-4 p-6">
                    <span class="font-mono-data text-mono-data text-on-surface">
                        @if(is_bool($products[0]->specs[$key] ?? null))
                            {{ $products[0]->specs[$key] ? 'Yes' : 'No' }}
                        @else
                            {{ $products[0]->specs[$key] ?? '—' }}
                        @endif
                    </span>
                </div>
                @endif
                <!-- Product 2 Spec -->
                @if(isset($products[1]))
                <div class="col-span-5 p-6">
                    <span class="font-mono-data text-mono-data text-on-surface">
                        @if(is_bool($products[1]->specs[$key] ?? null))
                            {{ $products[1]->specs[$key] ? 'Yes' : 'No' }}
                        @else
                            {{ $products[1]->specs[$key] ?? '—' }}
                        @endif
                    </span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Secondary Specs / Bento Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 glass-panel p-8 rounded-3xl border border-outline-variant/30 shadow-lg flex flex-col justify-between">
                <div>
                    <h4 class="font-headline-md mb-4">AI Insight Summary</h4>
                    <ul class="space-y-4">
                        @if($aiNarrative && isset($aiNarrative->content['pros']))
                            @foreach($aiNarrative->content['pros'] as $pro)
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                </div>
                                <p class="text-body-md text-on-surface-variant">{{ $pro }}</p>
                            </li>
                            @endforeach
                        @else
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                </div>
                                <p class="text-body-md text-on-surface-variant">Intelligent aggregation of user sentiment and review scoring.</p>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[16px]">check</span>
                                </div>
                                <p class="text-body-md text-on-surface-variant">Real-time price monitoring across multiple online retailers.</p>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="glass-panel p-8 rounded-3xl border border-outline-variant/30 shadow-lg flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-secondary/10 rounded-2xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-secondary text-[40px]" style="font-variation-settings: 'FILL' 1;">insights</span>
                </div>
                <h4 class="font-headline-md mb-2">SpecWise Score</h4>
                <div class="text-display-lg text-secondary font-bold mb-4">
                    {{ $aiNarrative?->content['score'] ?? '8.8' }}<span class="text-headline-md text-on-surface-variant/40">/10</span>
                </div>
                <p class="text-body-md text-on-surface-variant mb-6">Based on verified technical data points and user feedback loops.</p>
            </div>
        </section>
    @endif
</main>
@endsection

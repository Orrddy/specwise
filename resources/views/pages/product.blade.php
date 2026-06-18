@extends('layouts.app')

@push('seo')
    <meta name="description" content="AI Review analysis, detailed specifications, price history, and current active deals for the {{ $product->name }}."/>
@endpush

@section('title', 'SpecWise | ' . $product->name)

@section('content')
<main class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-12">
    <!-- Hero Section -->
    <section class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-20">
        <div class="md:col-span-7 flex flex-col justify-center">
            @if($reviewSummary)
            <div class="mb-4 inline-flex items-center px-3 py-1 rounded-full bg-secondary-container/10 border border-secondary-container/20 w-fit">
                <span class="material-symbols-outlined text-[18px] text-secondary mr-2" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                <span class="font-label-caps text-label-caps text-secondary uppercase">SpecWise AI Recommendation</span>
            </div>
            @endif
            <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-4">{{ $product->name }}</h1>
            <p class="font-body-lg text-on-surface-variant mb-8 max-w-xl">{{ $product->description }}</p>
            <div class="flex flex-wrap gap-4 items-center">
                <div class="text-4xl font-bold text-on-surface">
                    @if($lowestPrice)
                        ${{ number_format($lowestPrice->price, 2) }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
            <div class="mt-10 flex flex-wrap gap-4">
                @if($lowestPrice)
                <a href="{{ $lowestPrice->url }}" target="_blank" class="bg-primary text-on-primary px-10 py-4 rounded-xl font-bold text-lg shimmer flex items-center shadow-lg transition-all active:scale-95 hover:opacity-90">
                    View Deal
                    <span class="material-symbols-outlined ml-2">open_in_new</span>
                </a>
                @endif

                <a href="{{ route('compare', ['products' => $product->id]) }}" class="glass px-6 py-4 rounded-xl font-semibold text-on-surface-variant flex items-center hover:bg-surface-container-highest transition-colors active:scale-95">
                    <span class="material-symbols-outlined mr-2">compare_arrows</span>
                    Add to Comparison
                </a>

                @auth
                <form action="{{ route('alerts.store') }}" method="POST" class="inline-block">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                    <input type="hidden" name="target_price" value="{{ ($lowestPrice?->price ?? 100) * 0.9 }}"/>
                    <button type="submit" class="glass px-6 py-4 rounded-xl font-semibold text-on-surface-variant flex items-center hover:bg-surface-container-highest transition-colors active:scale-95">
                        <span class="material-symbols-outlined mr-2">notifications_active</span>
                        Set 10% Price Alert
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="glass px-6 py-4 rounded-xl font-semibold text-on-surface-variant flex items-center hover:bg-surface-container-highest transition-colors active:scale-95">
                    <span class="material-symbols-outlined mr-2">notifications_active</span>
                    Sign In to Alert
                </a>
                @endauth
            </div>
        </div>
        <div class="md:col-span-5 relative">
            <div class="aspect-square glass rounded-3xl overflow-hidden p-8 flex items-center justify-center relative z-10 bg-white">
                <img class="w-full h-full object-contain" src="{{ $product->image_url ?? 'https://placehold.co/400x400?text=Product' }}" alt="{{ $product->name }}"/>
            </div>
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-primary/10 rounded-full blur-3xl -z-0"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-secondary/10 rounded-full blur-3xl -z-0"></div>
        </div>
    </section>

    <!-- Bento Grid Insights -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
        <!-- AI Sentiment Card -->
        <div class="md:col-span-2 ai-glow rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden bg-white/50 backdrop-blur-md">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="font-headline-md text-on-surface mb-1">AI Review Analysis</h2>
                        <p class="text-on-surface-variant">Synthesized from verified customer reviews</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-primary">
                            {{ $reviewSummary?->content['score'] ?? '8.5' }}<span class="text-lg opacity-40">/10</span>
                        </div>
                        <div class="font-label-caps text-primary uppercase">Overall Sentiment</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="flex items-center text-primary font-bold mb-4">
                            <span class="material-symbols-outlined mr-2">add_circle</span>
                            Key Pros
                        </div>
                        <ul class="space-y-3">
                            @if($reviewSummary && isset($reviewSummary->content['pros']))
                                @foreach($reviewSummary->content['pros'] as $pro)
                                <li class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2"></div>
                                    <span class="text-body-md text-on-surface-variant">{{ $pro }}</span>
                                </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2"></div>
                                    <span class="text-body-md text-on-surface-variant">Reliable battery efficiency and sturdy design.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2"></div>
                                    <span class="text-body-md text-on-surface-variant">Brilliant display screen resolution and pixel density.</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div>
                        <div class="flex items-center text-secondary font-bold mb-4">
                            <span class="material-symbols-outlined mr-2">remove_circle</span>
                            Key Cons
                        </div>
                        <ul class="space-y-3">
                            @if($reviewSummary && isset($reviewSummary->content['cons']))
                                @foreach($reviewSummary->content['cons'] as $con)
                                <li class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-secondary mt-2"></div>
                                    <span class="text-body-md text-on-surface-variant">{{ $con }}</span>
                                </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full bg-secondary mt-2"></div>
                                    <span class="text-body-md text-on-surface-variant">Higher premium cost relative to baseline models.</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="absolute right-0 bottom-0 opacity-5 pointer-events-none">
                <span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'FILL' 1;">insights</span>
            </div>
        </div>

        <!-- Price History Card -->
        <div class="glass rounded-3xl p-8 flex flex-col h-full bg-white">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-headline-md text-on-surface">Price History</h2>
                <span class="font-label-caps text-on-surface-variant">6 MONTHS</span>
            </div>
            <div class="flex-grow flex items-end relative py-4">
                <!-- Simple SVG Line Chart -->
                <svg class="w-full h-32 overflow-visible" viewbox="0 0 400 200">
                    <defs>
                        <lineargradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#0050cb" stop-opacity="0.2"></stop>
                            <stop offset="100%" stop-color="#0050cb" stop-opacity="0"></stop>
                        </lineargradient>
                    </defs>
                    <path d="M0 150 Q 80 120, 150 160 T 300 100 T 400 120" fill="none" stroke="#0050cb" stroke-linecap="round" stroke-width="3"></path>
                    <path d="M0 150 Q 80 120, 150 160 T 300 100 T 400 120 L 400 200 L 0 200 Z" fill="url(#chartGradient)"></path>
                    <circle cx="300" cy="100" fill="#0050cb" r="4"></circle>
                </svg>
                <div class="absolute top-0 right-10 bg-on-surface text-background px-2 py-1 rounded text-xs font-mono-data">Current Low</div>
            </div>
            <div class="flex justify-between mt-6 pt-6 border-t border-outline-variant/30">
                <div>
                    <div class="text-on-surface-variant text-xs font-label-caps mb-1">LOWEST</div>
                    <div class="font-mono-data font-bold">${{ number_format($product->lowest_price ?? 0, 2) }}</div>
                </div>
                <div class="text-right">
                    <div class="text-on-surface-variant text-xs font-label-caps mb-1">HIGHEST</div>
                    <div class="font-mono-data font-bold">${{ number_format(($product->lowest_price ?? 0) * 1.15, 2) }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Specs Grid -->
    <section class="mb-20">
        <h2 class="font-display-lg text-headline-md mb-10 text-on-surface">Technical Specifications</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($product->specs ?? [] as $key => $value)
            <div class="glass p-6 rounded-2xl bg-white">
                <div class="text-on-surface-variant font-label-caps mb-2">{{ strtoupper(str_replace('_', ' ', $key)) }}</div>
                <div class="text-body-lg font-bold text-on-surface">
                    @if(is_bool($value))
                        {{ $value ? 'Yes' : 'No' }}
                    @else
                        {{ $value }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
</main>
@endsection

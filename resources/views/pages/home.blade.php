@extends('layouts.app')

@push('seo')
    <meta name="description" content="SpecWise - Compare products intelligently with AI. Real-time comparisons, price tracking, and AI-powered recommendations."/>
@endpush

@section('title', 'SpecWise | Compare Intelligently with AI')

@section('content')
<main class="relative">
    {{-- Hero Section --}}
    <section class="relative min-h-[870px] flex flex-col items-center justify-center px-margin-mobile md:px-margin-desktop py-20 overflow-hidden">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-primary/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-secondary/10 rounded-full blur-[100px]"></div>
        </div>
        <div class="z-10 text-center max-w-4xl mx-auto flex flex-col items-center">
            <span class="font-label-caps text-label-caps text-secondary mb-6 tracking-widest uppercase">Powered by Advanced AI</span>
            <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-8 max-w-3xl leading-tight">
                Compare Intelligently <br/><span class="text-primary">with AI</span>
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-12 max-w-2xl">
                SpecWise aggregates data from thousands of sources to give you real-time, objective comparisons across any category. Make your next purchase with super-intelligence.
            </p>
            {{-- AI Search Bar --}}
            <div class="w-full max-w-2xl ai-glow ai-glow-soft rounded-2xl p-0.5 group">
                <form action="{{ route('search') }}" method="GET">
                    <div class="glass rounded-[14px] flex items-center p-2 pr-4 shadow-xl transition-all duration-300 group-focus-within:bg-white">
                        <span class="material-symbols-outlined ml-4 text-primary opacity-60">search</span>
                        <input class="flex-grow bg-transparent border-none focus:ring-0 text-body-lg px-4 py-4 placeholder:text-outline" id="ai-search" name="q" placeholder="Try 'MacBook Pro M3 vs Dell XPS 15'..." type="text"/>
                        <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-8 py-3 rounded-xl font-bold shimmer hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-primary/20">
                            Analyze
                        </button>
                    </div>
                </form>
            </div>
            {{-- Category Pills --}}
            <div class="flex flex-wrap justify-center gap-3 mt-12">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="glass px-6 py-2.5 rounded-full border border-black/5 hover:border-primary/30 hover:bg-white transition-all duration-300 flex items-center gap-2 group">
                    <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">{{ $category->icon ?? 'category' }}</span>
                    <span class="font-label-caps text-label-caps text-on-surface-variant">{{ $category->name }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Trending Comparisons --}}
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-24">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface mb-2">Trending Comparisons</h2>
                <p class="text-on-surface-variant">What others are comparing right now across the globe.</p>
            </div>
            <a class="text-primary font-semibold flex items-center gap-1 hover:gap-2 transition-all" href="{{ route('search') }}">
                View all <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
        {{-- Comparison Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            @if($featuredComparison)
            {{-- Large Featured Comparison --}}
            <div class="md:col-span-8 group relative overflow-hidden rounded-3xl ai-glow-soft hover:shadow-2xl transition-all duration-500">
                <div class="absolute inset-0 glass z-0 group-hover:bg-white/80 transition-colors"></div>
                <div class="relative z-10 p-8 h-full flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 w-full flex items-center justify-between">
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden mb-4 shadow-lg group-hover:scale-105 transition-transform">
                                <img class="w-full h-full object-contain bg-white p-4" src="{{ $featuredComparison->product1->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $featuredComparison->product1->name }}"/>
                            </div>
                            <span class="font-headline-md text-on-surface text-center">{{ $featuredComparison->product1->name }}</span>
                        </div>
                        <div class="px-6 py-3 rounded-full bg-surface-container-highest font-mono-data text-primary font-bold">VS</div>
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl overflow-hidden mb-4 shadow-lg group-hover:scale-105 transition-transform">
                                <img class="w-full h-full object-contain bg-white p-4" src="{{ $featuredComparison->product2->image_url ?? 'https://placehold.co/200x200?text=Product' }}" alt="{{ $featuredComparison->product2->name }}"/>
                            </div>
                            <span class="font-headline-md text-on-surface text-center">{{ $featuredComparison->product2->name }}</span>
                        </div>
                    </div>
                    <div class="md:w-1/3 flex flex-col justify-center border-t md:border-t-0 md:border-l border-on-surface/5 pt-8 md:pt-0 md:pl-8">
                        <div class="bg-secondary/10 text-secondary px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase mb-4 w-fit">AI Verdict</div>
                        <p class="text-body-md text-on-surface-variant mb-6">{{ $featuredComparison->ai_summary ?? 'Click to see the full AI-powered comparison and verdict.' }}</p>
                        <a href="{{ route('compare', ['products' => implode(',', $featuredComparison->product_ids)]) }}" class="text-left font-bold text-primary flex items-center group/btn">
                            Full Insight Report
                            <span class="material-symbols-outlined ml-2 group-hover/btn:translate-x-1 transition-transform">trending_flat</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Small Grid Items --}}
            <div class="md:col-span-4 grid grid-rows-2 gap-gutter">
                @foreach($trendingComparisons as $comparison)
                <a href="{{ route('compare', ['products' => implode(',', $comparison->product_ids)]) }}" class="glass rounded-3xl p-6 border border-black/5 hover:border-primary/20 transition-all group block">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex -space-x-4">
                            <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden shadow-md">
                                <img class="w-full h-full object-cover" src="{{ $comparison->product1->image_url ?? 'https://placehold.co/48x48' }}" alt="{{ $comparison->product1->name }}"/>
                            </div>
                            <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden shadow-md">
                                <img class="w-full h-full object-cover" src="{{ $comparison->product2->image_url ?? 'https://placehold.co/48x48' }}" alt="{{ $comparison->product2->name }}"/>
                            </div>
                        </div>
                        <span class="font-label-caps text-label-caps text-on-surface-variant">{{ $comparison->category_name ?? 'Products' }}</span>
                    </div>
                    <h3 class="font-headline-md text-on-surface text-[18px] mb-2">{{ $comparison->product1->name }} vs {{ $comparison->product2->name }}</h3>
                    <p class="text-[14px] text-on-surface-variant">{{ $comparison->tagline ?? 'Click to see the AI comparison.' }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- AI Insights Feature --}}
    <section class="bg-surface-container-low py-32 px-margin-mobile md:px-margin-desktop overflow-hidden">
        <div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
            <div class="order-2 md:order-1 relative">
                <div class="relative bg-white rounded-3xl p-8 shadow-2xl border border-primary/10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">neurology</span>
                        </div>
                        <div class="flex-grow">
                            <div class="h-2 w-32 bg-surface-container-highest rounded-full mb-2"></div>
                            <div class="h-2 w-48 bg-surface-container-low rounded-full"></div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="flex justify-between items-center">
                            <span class="font-mono-data text-on-surface">Efficiency Score</span>
                            <div class="w-48 h-2 bg-surface-container rounded-full overflow-hidden"><div class="h-full bg-primary rounded-full" style="width: 85%;"></div></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-mono-data text-on-surface">Value Retention</span>
                            <div class="w-48 h-2 bg-surface-container rounded-full overflow-hidden"><div class="h-full bg-secondary rounded-full" style="width: 92%;"></div></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-mono-data text-on-surface">Durability Index</span>
                            <div class="w-48 h-2 bg-surface-container rounded-full overflow-hidden"><div class="h-full bg-primary-container rounded-full" style="width: 65%;"></div></div>
                        </div>
                    </div>
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary/20 blur-[60px] rounded-full"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary/20 blur-[60px] rounded-full"></div>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <h2 class="font-display-lg text-display-lg-mobile md:text-headline-md font-bold text-on-surface mb-8">Go Beyond the <br/><span class="text-surface-tint">Spec Sheet</span></h2>
                <p class="text-body-lg text-on-surface-variant mb-8 leading-relaxed">
                    Standard comparison sites just list numbers. SpecWise uses large language models to ingest thousands of verified reviews, technical teardowns, and user reports to synthesize an objective truth.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-4"><span class="material-symbols-outlined text-primary mt-1">check_circle</span><div><strong class="text-on-surface">Sentiment Synthesis:</strong> <span class="text-on-surface-variant">Aggregated pros and cons from real users.</span></div></li>
                    <li class="flex items-start gap-4"><span class="material-symbols-outlined text-primary mt-1">check_circle</span><div><strong class="text-on-surface">Market Predictions:</strong> <span class="text-on-surface-variant">AI-driven price forecasting and resale values.</span></div></li>
                    <li class="flex items-start gap-4"><span class="material-symbols-outlined text-primary mt-1">check_circle</span><div><strong class="text-on-surface">Custom Persona Matching:</strong> <span class="text-on-surface-variant">Recommendations tailored to your specific workflow.</span></div></li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Newsletter CTA --}}
    <section class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-32">
        <div class="bg-primary-container rounded-[40px] p-12 md:p-20 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary to-secondary opacity-20"></div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="font-headline-md text-headline-md text-white mb-6">Stay ahead of the curve.</h2>
                <p class="text-on-primary-container mb-10 text-body-lg opacity-90">Get weekly AI-curated reports on the newest hardware releases and comparative performance shifts.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <input class="flex-grow rounded-2xl border-none py-4 px-6 focus:ring-2 focus:ring-white/50 bg-white/20 text-white placeholder:text-white/60 backdrop-blur-sm" placeholder="Enter your email" type="email"/>
                    <button class="bg-white text-primary px-10 py-4 rounded-2xl font-bold hover:bg-opacity-90 transition-all active:scale-95 shadow-xl">Join the Inner Circle</button>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('ai-search');
    if (searchInput) {
        const searchContainer = searchInput.parentElement.parentElement;
        searchInput.addEventListener('focus', () => searchContainer.classList.add('scale-[1.02]'));
        searchInput.addEventListener('blur', () => searchContainer.classList.remove('scale-[1.02]'));
    }
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-10');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('section').forEach(section => {
        section.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
        observer.observe(section);
    });
</script>
@endpush

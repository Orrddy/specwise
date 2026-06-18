@extends('layouts.app')

@push('seo')
    <meta name="description" content="View your saved side-by-side product comparisons, active price tracking alerts, and SpecWise intelligence dashboard."/>
@endpush

@section('title', 'SpecWise | My Dashboard')

@section('content')
<main class="pt-24 pb-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <!-- Overview Section: Welcome -->
    <section class="mb-20">
        <div class="flex flex-col md:flex-row justify-between items-end gap-gutter">
            <div>
                <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-2">Welcome back, {{ auth()->user()->name }}.</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Your spec-hunting intelligence is ready. Tracked products, target prices, and AI insights organized in one place.</p>
            </div>
            <div class="flex gap-4">
                <div class="glass px-6 py-4 rounded-xl flex flex-col items-center">
                    <span class="font-label-caps text-label-caps text-secondary mb-1">SAVED TABLES</span>
                    <span class="font-headline-md text-headline-md font-bold">{{ $savedComparisons->count() }}</span>
                </div>
                <div class="glass px-6 py-4 rounded-xl flex flex-col items-center">
                    <span class="font-label-caps text-label-caps text-primary mb-1">ACTIVE ALERTS</span>
                    <span class="font-headline-md text-headline-md font-bold">{{ $activeAlerts->count() }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Layout for Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Saved Comparisons -->
        <div class="lg:col-span-2">
            <div class="flex justify-between items-center mb-6 px-2">
                <h2 class="font-headline-md text-headline-md text-on-surface">Recent Comparisons</h2>
                <a class="text-primary font-medium text-body-md hover:underline" href="#">View All</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
                @foreach($savedComparisons as $comp)
                <div class="glass p-6 rounded-xl hover:shadow-lg transition-all duration-300 group bg-white">
                    <div class="flex justify-between mb-4">
                        <div class="flex -space-x-3">
                            <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden bg-white shadow-sm">
                                <img class="w-full h-full object-cover" src="{{ $comp->product1->image_url ?? 'https://placehold.co/48x48' }}" alt="{{ $comp->product1->name ?? 'Product' }}"/>
                            </div>
                            <div class="w-12 h-12 rounded-full border-2 border-white overflow-hidden bg-white shadow-sm">
                                <img class="w-full h-full object-cover" src="{{ $comp->product2->image_url ?? 'https://placehold.co/48x48' }}" alt="{{ $comp->product2->name ?? 'Product' }}"/>
                            </div>
                        </div>
                        <span class="font-label-caps text-label-caps bg-primary/10 text-primary px-3 py-1 rounded-full h-fit">{{ $comp->category_name ?? 'Specs' }}</span>
                    </div>
                    <h3 class="font-headline-md text-body-lg font-bold mb-1">{{ $comp->title }}</h3>
                    <p class="text-body-md text-on-surface-variant mb-6">Last updated {{ $comp->updated_at->diffForHumans() }}</p>
                    <a href="{{ route('compare', ['products' => implode(',', $comp->product_ids)]) }}" class="w-full py-3 bg-secondary-container text-on-secondary-container rounded-lg font-semibold flex items-center justify-center gap-2 transition-all hover:bg-secondary text-white">
                        <span>View Comparison</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
                @endforeach

                <!-- Add New Card -->
                <a href="{{ route('search') }}" class="border-2 border-dashed border-outline-variant rounded-xl p-6 flex flex-col items-center justify-center text-on-surface-variant hover:border-primary hover:text-primary transition-all cursor-pointer bg-white/30 min-h-[220px]">
                    <span class="material-symbols-outlined text-[48px] mb-2">add_circle</span>
                    <span class="font-bold text-body-lg">New Comparison</span>
                </a>
            </div>
        </div>

        <!-- Price Alerts Section -->
        <div class="lg:col-span-1">
            <div class="glass p-6 rounded-2xl h-full bg-white">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-headline-md text-headline-md text-on-surface">Price Tracking</h2>
                    <span class="material-symbols-outlined text-primary">notifications_active</span>
                </div>
                <div class="space-y-6">
                    @forelse($activeAlerts as $alert)
                    <div class="pb-6 border-b border-outline-variant/30">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-label-caps text-[10px] text-on-surface-variant mb-1 uppercase tracking-widest">{{ $alert->product->category->name ?? 'Category' }}</p>
                                <h4 class="font-bold text-body-md">{{ $alert->product->name }}</h4>
                            </div>
                            <form action="{{ route('alerts.destroy', $alert->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-on-surface-variant hover:text-error">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                        <div class="flex justify-between items-end mb-2">
                            <div class="text-on-surface-variant text-body-md">Target: <span class="font-mono-data text-on-surface">${{ number_format($alert->target_price, 2) }}</span></div>
                            <div class="text-primary font-bold text-headline-md">${{ number_format($alert->current_price ?? 0, 2) }}</div>
                        </div>
                        <div class="w-full bg-surface-container rounded-full h-1.5 overflow-hidden">
                            <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: {{ $alert->progress }}%;"></div>
                        </div>
                        @if($alert->current_price <= $alert->target_price)
                        <p class="text-[12px] text-error mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">trending_down</span>
                            Price hit! Best time to buy.
                        </p>
                        @else
                        <p class="text-[12px] text-on-surface-variant mt-2">Nearing target price</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8 text-on-surface-variant">
                        No active price alerts. Start tracking on product detail pages!
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- AI Efficiency Insights -->
    <section class="mt-20">
        <div class="glass rounded-3xl p-margin-mobile md:p-margin-desktop overflow-hidden relative bg-white/50 backdrop-blur-md">
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        <span class="font-label-caps text-secondary">AI ANALYTICS</span>
                    </div>
                    <h2 class="font-headline-md text-display-lg-mobile md:text-headline-md font-bold mb-4">Your Intelligence Score</h2>
                    <p class="text-body-lg text-on-surface-variant mb-8">Based on your recent comparisons, you've optimized your budget efficiency by <span class="text-primary font-bold">18%</span> compared to market averages.</p>
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-white/50 backdrop-blur-sm p-4 rounded-xl border border-white/40">
                            <p class="text-label-caps text-on-surface-variant mb-1">DATA POINTS PROCESSED</p>
                            <p class="text-headline-md font-mono-data">14,204</p>
                        </div>
                        <div class="bg-white/50 backdrop-blur-sm p-4 rounded-xl border border-white/40">
                            <p class="text-label-caps text-on-surface-variant mb-1">SAVINGS PROJECTED</p>
                            <p class="text-headline-md font-mono-data">$420.00</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white/80 p-6 rounded-2xl shadow-sm border border-black/5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-body-md font-medium">Research Depth</span>
                            <span class="text-primary font-bold">92%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="bg-white/80 p-6 rounded-2xl shadow-sm border border-black/5">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-body-md font-medium">Value Optimization</span>
                            <span class="text-secondary font-bold">78%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full bg-secondary" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bars = document.querySelectorAll('.h-full.bg-primary, .h-full.bg-secondary');
        bars.forEach(bar => {
            const finalWidth = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1.5s cubic-bezier(0.65, 0, 0.35, 1)';
                bar.style.width = finalWidth;
            }, 300);
        });
    });
</script>
@endpush

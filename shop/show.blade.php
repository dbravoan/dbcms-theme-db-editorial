@extends('theme-db-editorial::layouts.app')

@section('title', ($translation->meta_title ?? $translation->name) . ' - Editorial dbCMS')
@section('meta_description', $translation->meta_description ?? $translation->summary ?? '')

@section('content')
<div class="max-w-6xl mx-auto space-y-16" x-data="{ activeImage: @js($product->featured_image ?? '') }">

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-sans text-stone-500">
        <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="hover:text-stone-900">{{ __(__('Catálogo')) }}</a>
        <span>/</span>
        @if($product->category)
            <span>{{ $product->category->localizedName() }}</span>
            <span>/</span>
        @endif
        <span class="text-stone-900 font-semibold">{{ $translation->name }}</span>
    </nav>

    <!-- Product Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        <!-- Left: Image Gallery -->
        <div class="space-y-4">
            <div class="editorial-card h-96 sm:h-[480px] bg-stone-100 rounded-2xl overflow-hidden flex items-center justify-center p-4">
                <template x-if="activeImage">
                    <img :src="activeImage" alt="{{ $translation->name }}" class="max-h-full max-w-full object-contain" loading="lazy" decoding="async">
                </template>
                <template x-if="!activeImage">
                    <div class="text-stone-300 text-6xl font-serif italic">dbCMS</div>
                </template>
            </div>

            <!-- Thumbnail Switcher -->
            @if(!empty($product->gallery_images) && count($product->gallery_images) > 0)
                <div class="flex items-center gap-3 overflow-x-auto pb-2">
                    @if($product->featured_image)
                        <button type="button" @click="activeImage = @js($product->featured_image)" class="w-16 h-16 rounded-lg overflow-hidden border-2 bg-stone-50 shrink-0 transition-all" :class="activeImage === @js($product->featured_image) ? 'border-stone-900' : 'border-stone-200 opacity-60 hover:opacity-100'">
                            <img src="{{ $product->featured_image }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </button>
                    @endif
                    @foreach($product->gallery_images as $gImg)
                        <button type="button" @click="activeImage = @js($gImg)" class="w-16 h-16 rounded-lg overflow-hidden border-2 bg-stone-50 shrink-0 transition-all" :class="activeImage === @js($gImg) ? 'border-stone-900' : 'border-stone-200 opacity-60 hover:opacity-100'">
                            <img src="{{ $gImg }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Specs, Pricing & Purchase / Quote Action Box -->
        <div class="editorial-card p-8 sm:p-10 space-y-6">
            <div class="space-y-2 border-b border-stone-200 pb-5">
                <div class="flex items-center justify-between font-sans">
                    <span class="text-xs text-amber-800 uppercase font-semibold tracking-wider">
                        {{ $product->category?->localizedName() ?? 'Editorial' }}
                    </span>
                    <span class="text-xs text-stone-400 font-mono">
                        REF: {{ $product->sku }}
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-serif font-bold text-stone-900 leading-tight">
                    {{ $translation->name }}
                </h1>
            </div>

            <!-- Short Summary -->
            <p class="text-stone-600 font-serif text-base leading-relaxed">
                {{ $translation->summary ?? 'Edición especial cuidada y disponible en distribución internacional.' }}
            </p>

            <!-- Actions: Cart vs Quote -->
            @include('shop::partials.product-offer')

            <!-- Technical Specifications Quick Preview -->
            @include('shop::partials.product-specifications')

        </div>

    </div>

    <!-- Modular Sections & Detailed Description -->
    @if(isset($renderedSections) && count($renderedSections) > 0)
        <section class="space-y-12">
            <h2 class="text-2xl font-serif font-bold text-stone-900 border-b border-stone-200 pb-3">
                Detalles de la Obra & Especificaciones
            </h2>
            @foreach($renderedSections as $sectionHtml)
                <div>
                    {!! $sectionHtml !!}
                </div>
            @endforeach
        </section>
    @elseif(!empty($translation->description))
        <section class="editorial-card p-8 sm:p-10 font-serif text-base text-stone-800 leading-relaxed max-w-none">
            {!! app(\DbCms\Core\Services\Media\MarkdownRendererService::class)->render((string) $translation->description) !!}
        </section>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <section class="space-y-6">
            <h2 class="text-2xl font-serif font-bold text-stone-900 border-b border-stone-200 pb-3">{{ __('Títulos Recomendados') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($relatedProducts as $rel)
                    @php
                        $relTrans = public_translation($rel, $currentLocale, $currentMarket ?? null);
                        $shopPrefix = app(\DbCms\Core\Contracts\Services\LocalizationServiceInterface::class)->getModulePrefix('shop', $currentLocale) ?: 'shop';
                        $relUrl = app(\DbCms\Core\Contracts\Services\LocalizationServiceInterface::class)->url("/{$shopPrefix}/{$relTrans?->slug}", $currentMarket);
                    @endphp
                    <a href="{{ $relUrl }}" class="editorial-card p-4 hover:shadow-md transition-all block space-y-3 group">
                        <div class="h-36 bg-stone-100 rounded-lg overflow-hidden flex items-center justify-center">
                            @if($rel->featured_image)
                                <img src="{{ $rel->featured_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy" decoding="async">
                            @else
                                <span class="text-3xl text-stone-300"><i class="fa-solid fa-book-open"></i></span>
                            @endif
                        </div>
                        <h4 class="font-serif font-bold text-stone-900 group-hover:text-amber-800 transition-colors truncate text-sm">{{ $relTrans?->name }}</h4>
                        @include('shop::partials.product-price', ['product' => $rel])
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Catalog Mode: Inquiry Modal -->


</div>

@endsection

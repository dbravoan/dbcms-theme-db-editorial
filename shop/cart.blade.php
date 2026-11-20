@extends('theme-db-editorial::layouts.app')

@section('title', __('shop::public.cart_title') . ' - Editorial dbCMS')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-sans">

    <div class="flex items-center justify-between border-b border-stone-200 pb-4">
        <div>
            <h1 class="text-3xl font-serif font-bold text-stone-900">
                {{ __('shop::public.cart_title') }}
            </h1>
            <p class="text-xs text-stone-500 mt-1">{{ __('shop::public.cart_subtitle') }}</p>
        </div>
        <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="text-stone-500 hover:text-stone-900 text-xs">
            &larr; {{ __('shop::public.continue_shopping') }}
        </a>
    </div>

    @if(empty($items))
        <div class="p-16 text-center editorial-card space-y-4">
            <span class="text-4xl block text-stone-400"><i class="fa-solid fa-bag-shopping"></i></span>
            <h3 class="text-xl font-serif font-bold text-stone-900">{{ __('shop::public.empty_cart') }}</h3>
            <p class="text-xs text-stone-500 max-w-sm mx-auto">{{ __('shop::public.empty_cart_description') }}</p>
            <a href="{{ route('shop.index', ['market' => $currentMarket->code, 'locale' => $currentLocale]) }}" class="px-5 py-2.5 bg-stone-900 text-white rounded-lg text-xs font-medium inline-block">{{ __('shop::public.explore_shop') }} &rarr;</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 editorial-card overflow-hidden">
                @include('shop::partials.cart-items', [
                    'items' => $items,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
            <div class="editorial-card p-6 space-y-4 h-fit">
                @include('shop::partials.cart-summary', [
                    'subtotal' => $subtotal,
                    'taxTotal' => $taxTotal,
                    'grandTotal' => $grandTotal,
                    'currentMarket' => $currentMarket,
                    'currentLocale' => $currentLocale,
                ])
            </div>
        </div>
    @endif

</div>
@endsection

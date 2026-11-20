@extends('theme-db-editorial::layouts.app')

@section('title', __('shop::public.checkout_title'))

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-sans">
    <div class="space-y-2">
        <h1 class="text-3xl font-serif font-bold text-stone-900">{{ __('shop::public.checkout_title') }}</h1>
        <p class="text-xs text-stone-500">{{ __('shop::public.checkout_description') }}</p>
    </div>
    <div class="editorial-card p-6">
        @include('shop::partials.checkout-form', [
            'items' => $items,
            'subtotal' => $subtotal,
            'taxTotal' => $taxTotal,
            'grandTotal' => $grandTotal,
            'currentMarket' => $currentMarket,
            'currentLocale' => $currentLocale,
        ])
    </div>
</div>
@endsection

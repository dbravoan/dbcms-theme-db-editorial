@extends('theme-db-editorial::layouts.app')

@section('title', __('shop::public.order_confirmed'))

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-sans">
    <h1 class="text-3xl font-serif font-bold text-stone-900">{{ __('shop::public.order_confirmed') }}</h1>
    <p class="text-sm opacity-75">{{ __('shop::public.order_description', ['email' => $order->customer_email]) }}</p>
    <div class="editorial-card p-6">
        @include('shop::partials.order-summary', [
            'order' => $order,
            'currentMarket' => $currentMarket,
            'currentLocale' => $currentLocale,
        ])
    </div>
</div>
@endsection

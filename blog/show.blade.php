@extends('theme-db-editorial::layouts.app')

@php
    $trans = public_translation($post);
    $marketCode = $currentMarket?->code ?? 'es';
    $markdownRenderer = app(\DbCms\Core\Services\Media\MarkdownRendererService::class);
    $renderedBody = $trans ? $markdownRenderer->render($trans->content) : '';
@endphp

@section('title', $trans->meta_title ?? $trans->title ?? __('Artículo'))
@section('meta_description', $trans->meta_description ?? $trans->summary ?? '')

@section('content')
<div class="max-w-4xl mx-auto space-y-12" @if(!empty($post)) data-cms-edit-url="{{ route('admin.blog.posts.edit', $post->id) }}" data-cms-edit-label="Editar Artículo" @endif>

    <!-- Breadcrumb Component -->
    @include('components.breadcrumbs', ['trail' => $breadcrumbs ?? []])

    <!-- Article Header -->
    <header class="space-y-6 text-center border-b border-stone-200 pb-10">
        <div class="inline-flex items-center gap-3 text-xs font-sans uppercase tracking-widest text-amber-800 font-semibold">
            <span>{{ public_translation($post->category)?->name ?? 'Ensayo' }}</span>
            <span>&bull;</span>
            <span>{{ ($post->published_at ?? now())->copy()->locale(app()->getLocale())->isoFormat('LL') }}</span>
            <span>&bull;</span>
            <span><i class="fa-solid fa-clock mr-1"></i> {{ $post->reading_time_minutes }} min de lectura</span>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-serif font-bold text-stone-900 tracking-tight leading-tight">
            {{ $trans->title ?? '' }}
        </h1>

        @if($trans->summary)
            <p class="text-lg sm:text-xl text-stone-600 font-serif italic max-w-2xl mx-auto leading-relaxed">
                {{ $trans->summary }}
            </p>
        @endif

        <div class="flex items-center justify-center space-x-3 pt-4 text-xs text-stone-600 font-sans">
            <div class="w-10 h-10 rounded-full bg-stone-200 text-stone-800 font-serif font-bold flex items-center justify-center text-sm border border-stone-300">
                {{ substr($post->author->name ?? 'A', 0, 1) }}
            </div>
            <div class="text-left">
                <span class="text-stone-900 font-semibold block">{{ $post->author->name ?? 'Redacción dbCMS' }}</span>
                <span class="text-stone-400 text-[11px]">{{ __('Investigación & Contenidos') }}</span>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->featured_image)
        <div class="rounded-2xl overflow-hidden border border-stone-200 shadow-sm">
            <img src="{{ $post->featured_image }}" alt="{{ $trans->title ?? '' }}" class="w-full max-h-[500px] object-cover" loading="eager" fetchpriority="high" decoding="async">
        </div>
    @endif

    <!-- Article Body & Modular Sections -->
    @if(isset($renderedSections) && count($renderedSections) > 0)
        <div class="space-y-10">
            @foreach($renderedSections as $sectionHtml)
                <div>
                    {!! $sectionHtml !!}
                </div>
            @endforeach
        </div>
    @else
        <article class="editorial-card p-8 sm:p-12 font-serif text-base text-stone-800 leading-relaxed space-y-6 max-w-none">
            {!! $renderedBody !!}
        </article>
    @endif

    @include('blog::partials.comments')

</div>

@endsection

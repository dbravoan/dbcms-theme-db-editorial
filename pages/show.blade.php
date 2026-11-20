@extends($layout ?? 'theme-db-editorial::layouts.app')

@section('title', $translation->meta_title ?? $translation->title ?? __('Página'))
@section('meta_description', $translation->meta_description ?? '')

@section('content')
<x-cms::content-region theme="db-editorial" class="gap-y-12 pb-16" :data-cms-edit-url="!empty($page) ? route('admin.pages.edit', $page->id) : false" data-cms-edit-label="Editar Página">
    @if(isset($renderedSections) && count($renderedSections) > 0)
        @foreach($renderedSections as $sectionHtml)
            {!! $sectionHtml !!}
        @endforeach
    @else
        <div class="max-w-4xl mx-auto px-4 py-20 text-center editorial-card p-8 font-serif">
            <h1 class="text-3xl font-bold text-stone-900 mb-2">{{ $translation->title ?? __('Página') }}</h1>
            <p class="text-stone-500 text-sm">{{ __('Esta página aún no tiene secciones asignadas en el constructor.') }}</p>
        </div>
    @endif
</x-cms::content-region>

<!-- Schema.org WebPage JSON-LD -->
@endsection

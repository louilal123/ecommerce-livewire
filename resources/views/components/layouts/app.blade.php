@php
    $user = auth()->user();
    $layout = match (true) {
        !$user => 'layouts.app.header',
        $user->role === \App\Enums\UserRole::Admin => 'layouts.app.sidebar',
        $user->role === \App\Enums\UserRole::User => 'layouts.app.header',
        default => abort(403, 'Unknown role'),
    };
@endphp


<x-dynamic-component :component="$layout" :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-dynamic-component>

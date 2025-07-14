<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head') {{--This includes  Vite assets, Livewire styles, etc. --}}
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
      
        <flux:header class="border-b border-zinc-200 dark:border-zinc-700 bg-white  dark:bg-zinc-900 flex-col sticky top-0">
            
          <x-top-header />

            <div class="flex w-full max-w-7xl mx-auto lg:px-4 py-4 items-center gap-1">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                    <x-app-logo />
                </a>
            
                    <flux:input.group class="justify-center w-full">
                        <flux:input icon="magnifying-glass"  placeholder="Search" class="w-full sm:max-w-lg" wire:model.live="search"/>
                        <flux:input.group.suffix>Search</flux:input.group.suffix>
                    </flux:input.group>
            
                <flux:spacer />
                
            <livewire:cart />


                @auth
                    <flux:dropdown position="top" align="end">
                        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
                        <flux:menu>
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>
                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                           <span class="truncate text-xs">
                                            {{ substr(auth()->user()->email, 0, 1) }}****{{ strstr(auth()->user()->email, '@') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>
                            <flux:menu.separator />
                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>
                            <flux:menu.separator />
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                @else
                    <nav class="hidden sm:flex items-center gap-4 ms-auto">
                        <flux:button :href="route('login')"  variant="filled" wire:navigate>
                            {{ __('Login') }}
                        </flux:button>

                        <flux:button :href="route('register')" variant="primary" color="indigo" wire:navigate>
                            {{ __('Register') }}
                        </flux:button>
                    </nav>

                @endauth
            </div>

        </flux:header>

        <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}" class=" flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo title="LECOMMERCE"/>
            </a>

            <flux:navlist variant="outline" class="h-full">
                @auth
                    <flux:navlist.group :heading="__('Main')">
                        <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navlist.item>
                   
                    </flux:navlist.group>
                @else
                    <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Shop') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="user" :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                        {{ __('Login') }}
                    </flux:navlist.item>
                    @if (Route::has('register'))
                        <flux:navlist.item icon="user-plus" :href="route('register')" :current="request()->routeIs('register')" wire:navigate>
                            {{ __('Register') }}
                        </flux:navlist.item>
                    @endif
                @endauth
            </flux:navlist>

            <flux:spacer  />

        </flux:sidebar>

        {{ $slot }} 

        @fluxScripts

         <x-footer />
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head') {{--This includes  Vite assets, Livewire styles, etc. --}}
    </head>
    <body class="min-h-screen flex flex-col bg-white dark:bg-zinc-800">
      
        <flux:header class="border-b border-zinc-200 dark:border-zinc-700 bg-white  dark:bg-zinc-900 flex-col sticky top-0">
            
            <div class="flex w-full max-w-7xl mx-auto lg:px-4 py-4 items-center gap-1">
                    {{-- <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" /> --}}
                    <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                        <x-app-icon /> CARTLIST
                    </a> 
                    <flux:spacer />
                    <nav class="hidden sm:flex items-center gap-4 ms-auto">
                        {{-- suppoed o be help page here  --}}
                        <flux:button :href="route('help')"  variant="filled" >
                            {{ __('Help') }}
                        </flux:button>
                    </nav>
            </div>

        </flux:header>

        {{ $slot }} 

        <flux:spacer />
                <flux:footer class="border-t border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 ">
                <div class="max-w-7xl mx-auto px-4 py-2 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ now()->year }} LeCommerce. All rights reserved.
                    </div>
                    <div class="flex gap-4 text-sm">
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">Terms</a>
                        <a href="#" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">Contact</a>
                    </div>
                </div>
            </flux:footer>
        @fluxScripts

          @include("components.flash-message")
    </body>
</html>
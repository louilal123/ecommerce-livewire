<section class="max-w-7xl mx-auto lg:px-4">

    <div class="relative mb-12 rounded-xl overflow-hidden ">
        <!-- Banner Content -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
            <div class="px-8 sm:px-12 lg:px-16 py-12 max-w-2xl">
                <flux:heading size="2xl" level="1" class="text-white mb-4">
                    Summer Sale Collection
                </flux:heading>
                <flux:subheading size="lg" class="text-white/90 mb-6">
                    Up to 50% off on selected items. Limited time offer!
                </flux:subheading>
                <div class="flex flex-wrap gap-3">
                    <flux:button variant="primary" class="px-6 py-3 text-base hover:scale-105 transition-transform">
                        Shop Now
                    </flux:button>
                    <flux:button variant="outline" class="px-6 py-3 text-base text-white border-white hover:bg-white/10">
                        Learn More
                    </flux:button>
                </div>
            </div>
        </div>
        
        <img 
            src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" 
            alt="Summer Sale" 
            class="w-full h-auto object-cover aspect-[3/1]"
            loading="eager"
        />
    </div>

    <flux:heading size="xl" class="mt-2 mb-2" level="1">{{ __('Categories') }}</flux:heading>
    <flux:subheading class="mb-4">{{ __('Browse popular categories') }}</flux:subheading>
      
    @include('components.toast-message')

    <div class="grid grid-cols-2 sm:grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-2 sm:gap-3">
       
            <div class="group  text-center cursor-pointer">
                <div class="relative  p-2 mb-3 rounded-sm border dark:border-zinc-700 hover:shadow-md transition-all 
                    duration-300 overflow-hidden ">
                    <div class="aspect-square w-full flex items-center justify-center">
                        <img 
                            src="{{ asset('storage/' . ) }}" 
                            alt="{{ }}" 
                            class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110 p-2" 
                        />
                    </div>
                </div>
                <flux:subheading size="sm" class="group-hover:text-gray-600 dark:group-hover:text-white">
                    {{ WHAT}}
                </flux:subheading>
            </div>
        @endforeach
    </div>
   <div class="flex items-center justify-between mt-8 mb-4">
        <div>
            <flux:heading size="xl" level="1">{{ __('Featured Products') }}</flux:heading>
            <flux:subheading>{{ __('Check out our best sellers') }}</flux:subheading>
        </div>

        <flux:link :href="route('products')" wire:navigate>
            {{ __('View All') }}
        </flux:link>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        
      
              <div class="group cursor-pointer border dark:border-zinc-700  rounded-xl  hover:shadow-sm transition-all duration-300 p-4 h-[340px] flex flex-col">
            
                    <div class="relative aspect-[4/3] w-full mb-3 overflow-hidden rounded-lg">
                     <a href="" wire:navigate>
                            <img 
                            src="{{ asset('storage/' e) }}" 
                                alt="{{ }}" 
                                class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" 
                                loading="lazy"
                            />
                       </a>
                    </div>

                    <flux:heading size="sm" class="mb-1 line-clamp-2 dark:text-white">
                        {{ }}
                    </flux:heading>

                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-400">
                            @for ($star = 1; $star <= 5; $star++)
                                <svg class="w-3 h-3 {{ $star <= 4 ? 'fill-current' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.954L10 0l2.951 5.956 
                                    6.561.954-4.756 4.635 1.122 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-500 text-xs ml-1 dark:text-gray-400">(23)</span>
                    </div>

                    <div class="mt-auto">
                        <div class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                            ₱{{ number_format( 2) }}
                         
                                <span class="text-xs text-gray-500 line-through ml-1.5 dark:text-gray-400">
                                    ₱{{ number_format() }}
                                </span>
                            @endif
                        </div>
                        
                    <livewire:addtocart-button />

                </div>
            </div>
        @endforeach

    </div>
    
</section>

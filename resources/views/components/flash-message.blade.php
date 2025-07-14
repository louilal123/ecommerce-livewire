@session('success')
    <div x-data="{ showToast: false }" x-init="setTimeout(() => showToast = true, 100)">
        <div x-show="showToast"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-10"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-10"
            class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg"
            x-init="setTimeout(() => showToast = false, 3000)">
            <p class="text-sm">{{ $value }}</p>
        </div>
    </div>
@endSession


@session('warning')
    <div x-data="{ showToast: false }" x-init="setTimeout(() => showToast = true, 100)">
        <div x-show="showToast"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-10"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-10"
            class="fixed top-5 right-5 bg-yellow-500 text-white p-4 rounded-lg shadow-lg"
            x-init="setTimeout(() => showToast = false, 3000)">
            <p class="text-sm">{{ $value }}</p>
        </div>
    </div>
@endSession

@session('error')
    <div x-data="{ showToast: false }" x-init="setTimeout(() => showToast = true, 100)">
        <div x-show="showToast"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-10"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-10"
            class="fixed top-5 right-5 bg-red-500 text-white p-4 rounded-lg shadow-lg"
            x-init="setTimeout(() => showToast = false, 3000)">
            <p class="text-sm">{{ $value }}</p>
        </div>
    </div>
@endSession
{{-- 
USE CASES IN THE LIVEWIRE COMPONENT: : //NOTE

session()->flash('success', 'Added to cart!');
session()->flash('warning', 'Stock is low!');
session()->flash('error', 'Unable to add item.'); 

--}}


<div>
    <flux:heading size="xl" level="4">
        {{ __('Dashboard') }}
    </flux:heading>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2 mb-8">
        {{-- Revenue Card --}}
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow border dark:border-zinc-700">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Revenue</h2>
                <span class="px-2 py-1 text-sm rounded-full flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    +12.5%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">₱2,627.00</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">vs ₱2,428.00 last period</p>
                </div>
                <div class="h-12 w-20 bg-indigo-50 dark:bg-indigo-900/20 rounded flex items-end">
                    <div class="h-8 w-3 bg-indigo-400 mx-0.5 rounded-t"></div>
                    <div class="h-10 w-3 bg-indigo-400 mx-0.5 rounded-t"></div>
                    <div class="h-6 w-3 bg-indigo-300 mx-0.5 rounded-t"></div>
                    <div class="h-12 w-3 bg-indigo-500 mx-0.5 rounded-t"></div>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700">
                <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                    View detailed report
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Orders Card --}}
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow border dark:border-zinc-700">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Orders</h2>
                <span class="px-2 py-1 text-sm rounded-full flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    2 new
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">2</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">vs 3 last period</p>
                </div>
                <div class="h-12 w-20 bg-blue-50 dark:bg-blue-900/20 rounded flex items-end">
                    <div class="h-8 w-3 bg-blue-400 mx-0.5 rounded-t"></div>
                    <div class="h-5 w-3 bg-blue-400 mx-0.5 rounded-t"></div>
                    <div class="h-10 w-3 bg-blue-300 mx-0.5 rounded-t"></div>
                    <div class="h-7 w-3 bg-blue-500 mx-0.5 rounded-t"></div>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700">
                <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                    View all orders
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Conversion Card --}}
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow border dark:border-zinc-700">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Conversion</h2>
                <span class="px-2 py-1 text-sm rounded-full flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    +0.7%
                </span>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">2.5%</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">vs 1.8% last period</p>
                </div>
                <div class="h-12 w-20 bg-purple-50 dark:bg-purple-900/20 rounded flex items-end">
                    <div class="h-6 w-3 bg-purple-400 mx-0.5 rounded-t"></div>
                    <div class="h-4 w-3 bg-purple-400 mx-0.5 rounded-t"></div>
                    <div class="h-8 w-3 bg-purple-300 mx-0.5 rounded-t"></div>
                    <div class="h-10 w-3 bg-purple-500 mx-0.5 rounded-t"></div>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700">
                <a href="#" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline flex items-center">
                    Optimize funnel
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

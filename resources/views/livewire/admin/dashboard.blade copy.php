<div class="mt-0 relative overflow-hidden">
    <!-- Background KPIs pattern (subtle and non-distracting) -->
    <div class="absolute inset-0 -z-10 opacity-10 dark:opacity-[0.03]">
        <div class="grid grid-cols-4 gap-8 h-full w-full">
            <div class="border-r border-gray-200 dark:border-zinc-700 flex flex-col justify-between">
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">Q1 Target</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">MRR</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">+12.5%</div>
            </div>
            <div class="border-r border-gray-200 dark:border-zinc-700 flex flex-col justify-between">
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">Conversion</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">2.5%</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">+0.7%</div>
            </div>
            <div class="border-r border-gray-200 dark:border-zinc-700 flex flex-col justify-between">
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">Orders</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">2</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">-33%</div>
            </div>
            <div class="flex flex-col justify-between">
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">Revenue</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">₱2,627</div>
                <div class="text-right text-xs text-gray-400 dark:text-zinc-600">+8.2%</div>
            </div>
        </div>
    </div>

    <flux:heading size="xl" level="4">
        {{ __('Performance Dashboard') }}
    </flux:heading>

    <div class="flex">
        <div class="flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 mt-2">

                <!-- Revenue Card - Enhanced with sparkline chart -->
                <div class="bg-white dark:bg-zinc-900/70 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-zinc-700/50 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/30 to-white/30 dark:from-indigo-900/10 dark:to-zinc-900/10 -z-10"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Revenue</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Monthly recurring</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 flex items-center">
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
                        <div class="h-12 w-20">
                            <svg viewBox="0 0 100 50" class="w-full h-full">
                                <polyline fill="none" stroke="currentColor" stroke-width="2" 
                                          points="10,40 30,20 50,30 70,10 90,25" 
                                          class="text-indigo-400 dark:text-indigo-500"/>
                                <circle cx="90" cy="25" r="3" fill="currentColor" class="text-indigo-500 dark:text-indigo-400"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700/50">
                        <a href="#" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline flex items-center group">
                            View detailed report
                            <svg class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Orders Card - Enhanced with order status indicators -->
                <div class="bg-white dark:bg-zinc-900/70 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-zinc-700/50 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-white/30 dark:from-blue-900/10 dark:to-zinc-900/10 -z-10"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Orders</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Today's count</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 flex items-center">
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
                        <div class="flex space-x-2">
                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-medium">1</span>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <span class="text-green-600 dark:text-green-400 text-sm font-medium">1</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700/50">
                        <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline flex items-center group">
                            View all orders
                            <svg class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Conversion Card - Enhanced with radial progress indicator -->
                <div class="bg-white dark:bg-zinc-900/70 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-zinc-700/50 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50/30 to-white/30 dark:from-purple-900/10 dark:to-zinc-900/10 -z-10"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Conversion</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Visitor to customer</p>
                        </div>
                        <span class="px-2 py-1 text-sm rounded-full bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 flex items-center">
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
                        <div class="relative w-12 h-12">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <path
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#e0e0e0"
                                    stroke-width="3"
                                    class="dark:stroke-zinc-700"
                                />
                                <path
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-dasharray="25, 100"
                                    class="text-purple-500 dark:text-purple-400"
                                    stroke-linecap="round"
                                />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center text-xs font-medium text-purple-600 dark:text-purple-400">
                                25%
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-2 border-t border-gray-100 dark:border-zinc-700/50">
                        <a href="#" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline flex items-center group">
                            Optimize funnel
                            <svg class="w-5 h-5 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
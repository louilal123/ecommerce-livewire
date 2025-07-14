<div
    x-data="{ show: false, message: '' }"
    x-on:toast.window="
        message = $event.detail.message;
        show = true;
        setTimeout(() => show = false, 3000);
    "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform -translate-y-full opacity-0"
    x-transition:enter-end="transform translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="transform translate-y-0 opacity-100"
    x-transition:leave-end="transform -translate-y-full opacity-0"
    class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50"
    style="display: none;"
>
    <p class="text-sm" x-text="message"></p>
</div>

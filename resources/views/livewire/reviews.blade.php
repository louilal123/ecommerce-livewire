<div class="mt-6 space-y-4">
  <flux:heading size="xl" class="mb-2" level="1">{{ __('Reviews and Ratings') }}</flux:heading>
  <flux:subheading class="mb-4">{{ __('Reviews from customers.') }}</flux:subheading>

  <div class="bg-white dark:bg-zinc-900 p-2 rounded-xl  -zinc-200 dark:-zinc-700">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">4.6 <span class="text-base font-normal text-zinc-600">out of 5</span></div>
        <div class="flex gap-1 mt-1">
          @for ($i = 0; $i < 5; $i++)
            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.05 3.235h3.397c.969 0 1.371 1.24.588 1.81l-2.748 1.996 1.05 3.235c.3.921-.755 1.688-1.54 1.118L10 11.347l-2.748 1.996c-.785.57-1.84-.197-1.54-1.118l1.05-3.235-2.748-1.996c-.783-.57-.38-1.81.588-1.81h3.397l1.05-3.235z"/>
            </svg>
          @endfor
        </div>
      </div>
      <flux:button variant="outline" class="text-sm" href="{{ route('products') }}">
        View All Products
      </flux:button>
    </div>
  </div>
  {{-- Review 1 --}}
  <div class=" rounded-xl p-2 dark:-zinc-700 bg-white dark:bg-zinc-900">
    <div class="flex items-center gap-3 mb-2">
      <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full" alt="avatar" />
      <div>
        <div class="font-medium text-zinc-900 dark:text-zinc-100">angelbyul</div>
        <div class="text-sm text-zinc-500">2024-08-27 · Variation: Black, XL</div>
      </div>
    </div>
    <div class="flex gap-1 mb-2">
      @for ($i = 0; $i < 5; $i++)
        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.05 3.235h3.397c.969 0 1.371 1.24.588 1.81l-2.748 1.996 1.05 3.235c.3.921-.755 1.688-1.54 1.118L10 11.347l-2.748 1.996c-.785.57-1.84-.197-1.54-1.118l1.05-3.235-2.748-1.996c-.783-.57-.38-1.81.588-1.81h3.397l1.05-3.235z"/>
        </svg>
      @endfor
    </div>
    <div class="text-sm text-zinc-700 dark:text-zinc-300 mb-1">
      <strong>Appearance:</strong> good<br>
      <strong>Colour:</strong> cute<br>
      <strong>Material Quality:</strong> cotton, comfortable
    </div>
    <div class="text-sm text-zinc-800 dark:text-zinc-200 mb-3">
      Fast delivery, no damage at tama lahat ng size ng inoder ko, at masarap sya isuot, no need na hila dito hila dun.
    </div>
    <div class="grid grid-cols-3 gap-2">
      <img src="https://i.pravatar.cc/40" class="rounded-md" alt="review" />
      <img src="https://i.pravatar.cc/40" class="rounded-md" alt="review" />
      <img src="https://i.pravatar.cc/40" class="rounded-md" alt="review" />
    </div>
  </div>

   <flux:separator />
  {{-- Review 2 --}}
  <div class=" rounded-xl p-2 -zinc-200 dark:-zinc-700 bg-white dark:bg-zinc-900">
    <div class="flex items-center gap-3 mb-2">
      <img src="https://i.pravatar.cc/41" class="w-10 h-10 rounded-full" alt="avatar" />
      <div>
        <div class="font-medium text-zinc-900 dark:text-zinc-100">babaaaab</div>
        <div class="text-sm text-zinc-500">2024-07-15 · Variation: White, M</div>
      </div>
    </div>
    <div class="flex gap-1 mb-2">
      @for ($i = 0; $i < 4; $i++)
        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.05 3.235h3.397c.969 0 1.371 1.24.588 1.81l-2.748 1.996 1.05 3.235c.3.921-.755 1.688-1.54 1.118L10 11.347l-2.748 1.996c-.785.57-1.84-.197-1.54-1.118l1.05-3.235-2.748-1.996c-.783-.57-.38-1.81.588-1.81h3.397l1.05-3.235z"/>
        </svg>
      @endfor
    </div>
    <div class="text-sm text-zinc-700 dark:text-zinc-300 mb-1">
      <strong>Appearance:</strong> decent<br>
      <strong>Colour:</strong> white<br>
      <strong>Material Quality:</strong> breathable, soft
    </div>
    <div class="text-sm text-zinc-800 dark:text-zinc-200 mb-3">
      Not bad for the price. Medyo manipis but okay naman pang bahay.
    </div>
    <div class="grid grid-cols-2 gap-2">
      <img src="https://i.pravatar.cc/40" class="rounded-md" alt="review" />
      <img src="https://i.pravatar.cc/40" class="rounded-md" alt="review" />
    </div>
  </div>
</div>

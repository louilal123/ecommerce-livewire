@if ($message = Session::get('success'))
    <div class="fixed top-6 right-6 z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-md">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="fixed top-6 right-6 z-50 bg-orange-500 text-white px-4 py-3 rounded-lg shadow-md">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="fixed top-6 right-6 z-50 bg-red-500 text-white px-4 py-3 rounded-lg shadow-md">
        {{ $message }}
    </div>
@endif

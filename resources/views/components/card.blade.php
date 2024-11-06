@props(['title'])
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>

        <div class="py-4 text-gray-900">
            {{ $slot }}
        </div>
    </div>
</div>

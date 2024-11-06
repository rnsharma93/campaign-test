<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-50">
            <tr class="w-full bg-gray-100">
                {{ $header }}
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>

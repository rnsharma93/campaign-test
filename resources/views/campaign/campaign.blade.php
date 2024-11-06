@extends('layouts.app')

@section('content')
    <x-card title="Campaigns">
        <div class="pb-6">
            <h2>
                UTM Campaign : <b>{{ $campaign->utm_campaign }}</b>
            </h2>
        </div>

        @if(!empty($stats) && $stats->isNotEmpty())
            <x-table>
                <x-slot name="header">
                    <x-table-th >Date</x-table-th>
                    <x-table-th >Hour</x-table-th>
                    <x-table-th >Total Revenue</x-table-th>
                </x-slot>

                @foreach($stats as $stat)
                    <tr>
                        <x-table-td>{{ $stat->date }}</x-table-td>
                        <x-table-td>{{ $stat->hours . ' - ' . ($stat->hours + 1) }}</x-table-td>
                        <x-table-td> {{ $stat->total_revenue }} </x-table-td>
                    </tr>
                @endforeach
            </x-table>

            <div class="py-6 bg-white overflow-hidden">
                {{ $stats->links() }}
            </div>

        @else
            <div class="py-6">
                <p class="text-gray-900">No campaigns found.</p>
            </div>
        @endif

    </x-card>
@endsection

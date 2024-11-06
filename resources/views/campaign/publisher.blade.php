@extends('layouts.app')

@section('content')
    <x-card title="Campaigns">
        <div class="pb-6">
            <h2>
                UTM Campaign : <b>{{ $campaign->utm_campaign }}</b>
            </h2>
        </div>

        @if(!empty($termStats) && $termStats->isNotEmpty())
            <x-table>
                <x-slot name="header">
                    <x-table-th >UTM Term ID</x-table-th>
                    <x-table-th >UTM Term</x-table-th>
                    <x-table-th >Total Revenue</x-table-th>
                </x-slot>

                @foreach($termStats as $stat)
                    <tr>
                        <x-table-td>{{ $stat->id }}</x-table-td>
                        <x-table-td>{{ $stat->utm_term }}</x-table-td>
                        <x-table-td> {{ $stat->total_revenue }} </x-table-td>
                    </tr>
                @endforeach
            </x-table>

            <div class="py-6 bg-white overflow-hidden">
                {{ $termStats->links() }}
            </div>

        @else
            <div class="py-6">
                <p class="text-gray-900">No campaigns found.</p>
            </div>
        @endif

    </x-card>
@endsection

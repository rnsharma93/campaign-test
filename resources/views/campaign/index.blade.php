@extends('layouts.app')

@section('content')
    <x-card title="Campaigns">
        @if($campaigns->isNotEmpty())
            <x-table>
                <x-slot name="header">
                    <x-table-th >UTM Campaign</x-table-th>
                    <x-table-th >Aggregate Revenue</x-table-th>
                    <x-table-th >Actions</x-table-th>
                </x-slot>

                @foreach($campaigns as $campaign)
                    <tr>
                        <x-table-td>{{ $campaign->utm_campaign }}</x-table-td>
                        <x-table-td>{{ $campaign->total_revenue }}</x-table-td>
                        <x-table-td>
                            <div>
                                <x-button href="{{ route('campaign', $campaign) }}" class=" mr-2">Details</x-button>
                                <x-button href="{{ route('publishers', $campaign) }}" >Publishers</x-button>
                            </div>
                        </x-table-td>
                    </tr>
                @endforeach
            </x-table>

            <div class="py-6 bg-white overflow-hidden">
                {{ $campaigns->links() }}
            </div>

        @else
            <div class="py-6">
                <p class="text-gray-900">No campaigns found.</p>
            </div>
        @endif
    </x-card>
@endsection

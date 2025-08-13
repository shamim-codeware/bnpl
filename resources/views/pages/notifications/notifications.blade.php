@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')

    {{-- Notifications --}}
    <div class="container-fluid mt-5">
        @forelse ($notifications as $key => $notify)
            @if (Auth::user()->role_id == 3)

              <a href="{{ url('notificatoins-seen', $notify->id) }}" class="btn btn-white d-block w-100 p-0 mb-3">
                    <div class="alert d-flex align-items-center justify-content-between alert-warning alert-dismissible fade show"
                        role="alert">
                        <p>Your order {{ $notify->hirepurchase->order_no ?? '' }} has been approved. Please confirm your sale.</p>
                    </div>
                </a>

              
            @elseif (Auth::user()->role_id == 6)

              <a href="{{ url('notificatoins-seen', $notify->id) }}" class="btn btn-white d-block w-100 p-0 mb-3">
                    <div class="alert d-flex align-items-center justify-content-between alert-warning alert-dismissible fade show"
                        role="alert">
                        <p>New order received for approval: {{ $notify->hirepurchase->order_no ?? '' }} from
                            {{ $notify->showroom->name ?? '' }} Showroom.</p>
                    </div>
                </a>
              
            @endif
        @empty
            <h2>The notification is currently unavailable</h2>
        @endforelse

        @if (count($notifications) > 0)
            <a class="btn btn-sm btn-danger float-right" href="{{ url('clear-all') }}">Clear All</a>
        @endif
    </div>


@endsection

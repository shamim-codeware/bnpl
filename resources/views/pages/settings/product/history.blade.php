@section('title','Product History')
@section('description','Product update history')
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Product History</h6>
                            <p class="mb-0">{{ $product->product_model }} | {{ $product->types->name ?? 'N/A' }} | {{ $product->categories->name ?? 'N/A' }}</p>
                        </div>
                        <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">Back to Products</a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p><strong>Total updates:</strong> {{ $audits->count() }}</p>
                            <p><strong>Last updated by:</strong> {{ optional($product->updater)->name ?? 'N/A' }}</p>
                        </div>

                        @if($audits->isEmpty())
                            <div class="alert alert-info">No history records found for this product.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                            <th>Changes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audits as $key => $audit)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ date('d/m/Y H:i', strtotime($audit->updated_at)) }}</td>
                                                <td>{{ optional($audit->user)->name ?? 'Unknown' }}</td>
                                                <td>
                                                    @if(is_array($audit->changed_fields) && count($audit->changed_fields))
                                                        <ul class="mb-0">
                                                            @foreach($audit->changed_fields as $field => $values)
                                                                <li><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> {{ $values['old'] ?? '—' }} &rarr; {{ $values['new'] ?? '—' }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span>No field changes recorded.</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

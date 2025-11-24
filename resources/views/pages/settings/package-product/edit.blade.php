@extends('layout.app')
@section('title', $title)
@section('description', $description)

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4">
                    <div class="card-header">
                        <h6>{{ $title }}</h6>
                    </div>
                    <div class="card-body py-md-30">
                        <form action="{{ route('package-product.update', $packageItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-4"> {{-- g-4 = gap between columns --}}
                                <!-- Package Select -->
                                <div class="col-md-6">
                                    <label class="form-label">Package <span class="text-danger">*</span></label>
                                    <select name="package_id" class="form-control ih-medium ip-lightradius-xs b-light" required>
                                        <option value="">Select Package</option>
                                        @foreach($packages as $pkg)
                                            <option value="{{ $pkg->id }}" {{ old('package_id', $packageItem->package_id) == $pkg->id ? 'selected' : '' }}>
                                                {{ $pkg->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Product Select -->
                                <div class="col-md-6">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="select-model" class="form-control ih-medium ip-lightradius-xs b-light" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}" {{ old('product_id', $packageItem->product_id) == $prod->id ? 'selected' : '' }}>
                                                {{ $prod->product_model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12 d-flex gap-3 pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary customr-btn">Update</button>
                                    <a href="{{ route('package-product.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

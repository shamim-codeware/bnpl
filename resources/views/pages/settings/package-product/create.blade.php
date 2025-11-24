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
                            <form action="{{ route('package-product.store') }}" method="POST">
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row mb-4">
                                    <!-- Package Select -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Package <span class="text-danger">*</span></label>
                                        <select name="package_id" class="form-control ih-medium ip-lightradius-xs b-light" required>
                                            <option value="">Select Package</option>
                                            @foreach ($packages as $pkg)
                                                <option value="{{ $pkg->id }}" {{ old('package_id') == $pkg->id ? 'selected' : '' }}>
                                                    {{ $pkg->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Product Select (Multi-select) -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Products <span class="text-danger">*</span></label>
                                        <select name="product_id[]" id="select-model"
                                            class="form-control ih-medium ip-lightradius-xs b-light" multiple required>
                                            <option value="">Select Products</option>
                                            @foreach ($products as $prod)
                                                <option value="{{ $prod->id }}"
                                                    {{ is_array(old('product_id')) && in_array($prod->id, old('product_id')) ? 'selected' : '' }}>
                                                    {{ $prod->product_model }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Save</button>
                                    <a href="{{ route('package-product.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

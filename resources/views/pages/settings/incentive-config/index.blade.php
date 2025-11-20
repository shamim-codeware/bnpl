@extends('layout.app')

@section('title',$title)
@section('description',$description)

@section('content')

<style>
    .select2-container--default .select2-selection--multiple,
    .select2-container--default .select2-selection--single {
        height: 40px;
    }

    .support-form .support-order-search .support-order-search__form {
        border: 1px solid #ddd;
    }

    .search-btn-btn {
        border-radius: 0px 5px 5px 0px;
    }

    .incentive-type-selector {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .incentive-type-selector label {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .incentive-type-selector input[type="radio"] {
        margin-right: 8px;
    }

    .general-config-section {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .general-config-section h6 {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid">
    <div class="form-element">
        <!-- General Incentive Configuration Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4">
                    <div class="card-header">
                        <h6>Sales & Collection Incentive</h6>
                    </div>
                    <div class="card-body py-md-30">
                        <form action="{{ route('general-incentive-config.store') }}" method="post">
                            @csrf

                            <div class="form-group row mb-25">
                                <div class="col-md-4 mb-25">
                                    <label class="form-label">Down Payment Threshold (%) <span class="text-danger">*</span></label>
                                    <div class="with-icon">
                                        <input style="padding: 0 20px !important"
                                               required
                                               type="number"
                                               step="0.01"
                                               min="0"
                                               max="100"
                                               name="down_payment_threshold"
                                               class="form-control px-2 ih-medium ip-lightradius-xs b-light"
                                               placeholder="Enter percentage (e.g., 40)"
                                               value="{{ $downPaymentThreshold ? $downPaymentThreshold->value : 40 }}">
                                    </div>
                                    <small class="text-muted">Minimum down payment percentage for incentive eligibility</small>
                                </div>

                                <div class="col-md-4 mb-25">
                                    <label class="form-label">Down Payment Incentive Rate (%) <span class="text-danger">*</span></label>
                                    <div class="with-icon">
                                        <input style="padding: 0 20px !important"
                                               required
                                               type="number"
                                               step="0.01"
                                               min="0"
                                               max="100"
                                               name="down_payment_incentive_rate"
                                               class="form-control px-2 ih-medium ip-lightradius-xs b-light"
                                               placeholder="Enter rate (e.g., 0.5)"
                                               value="{{ $downPaymentIncentiveRate ? $downPaymentIncentiveRate->value : 0.5 }}">
                                    </div>
                                    <small class="text-muted">Incentive rate for down payment</small>
                                </div>

                                <div class="col-md-4 mb-25">
                                    <label class="form-label">Collection Incentive Rate (%) <span class="text-danger">*</span></label>
                                    <div class="with-icon">
                                        <input style="padding: 0 20px !important"
                                               required
                                               type="number"
                                               step="0.01"
                                               min="0"
                                               max="100"
                                               name="collection_incentive_rate"
                                               class="form-control px-2 ih-medium ip-lightradius-xs b-light"
                                               placeholder="Enter rate (e.g., 2.5)"
                                               value="{{ $collectionIncentiveRate ? $collectionIncentiveRate->value : 2.5 }}">
                                    </div>
                                    <small class="text-muted">Incentive rate for timely collection</small>
                                </div>
                            </div>

                            <div class="col-md-4 form-basic pb-4">
                                <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Specific Incentive Configuration Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            @if (Auth::user()->user_action(1))
                                <div class="card-header">
                                    <h6>Add Category & Model Specific Incentive Configuration</h6>
                                </div>
                                <div class="card-body py-md-30">
                                    <form action="{{ route('incentive-configuration.store') }}" method="post">
                                        @csrf

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="form-group row mb-25">
                                            <!-- Incentive Type Selection -->
                                            <div class="col-md-12 mb-25">
                                                <label class="form-label"><strong>Incentive Type:</strong></label>
                                                <div class="incentive-type-selector">
                                                    <label>
                                                        <input type="radio" name="type" value="category" id="type-category" checked>
                                                        <span>Product Category Wise</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="type" value="model" id="type-model">
                                                        <span>Model Wise</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Category Selection (shown by default) -->
                                            <div class="col-md-4 mb-25" id="category-selector">
                                                <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                                <div class="select-style2">
                                                    <div class="dm-select">
                                                        <select name="reference_id" id="select-category" class="form-control">
                                                            <option value="">Select Category</option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Model Selection (hidden by default) -->
                                            <div class="col-md-4 mb-25" id="model-selector" style="display: none;">
                                                <label class="form-label">Select Product Model <span class="text-danger">*</span></label>
                                                <div class="select-style2">
                                                    <div class="dm-select">
                                                        <select name="reference_id" id="select-model" class="form-control">
                                                            <option value="">Select Model</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}">{{ $product->product_model }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Incentive Amount -->
                                            <div class="col-md-4 mb-25">
                                                <label class="form-label">Incentive Amount (Tk) <span class="text-danger">*</span></label>
                                                <div class="with-icon">
                                                    <input style="padding: 0 20px !important" required type="number" step="0.01" min="0" name="incentive_amount" class="form-control px-2 ih-medium ip-lightradius-xs b-light" placeholder="Enter Amount">
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-md-4 form-basic pb-4">
                                                <label class="form-label" style="visibility: hidden;">Action</label>
                                                <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Save Incentive</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100">
                            <div class="col">
                                <form action="{{ route('incentive-configuration.index') }}" method="GET" class="filter-type-form">
                                    <div class="select-style2">
                                        <div class="dm-select">
                                            <select onchange="this.form.submit()" name="type" class="form-control">
                                                <option value="">All Types</option>
                                                <option value="category" {{ request('type') == 'category' ? 'selected' : '' }}>Category Wise</option>
                                                <option value="model" {{ request('type') == 'model' ? 'selected' : '' }}>Model Wise</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end">
                                <div class="support-form__search">
                                    <div class="support-order-search">
                                        <form action="{{ route('incentive-configuration.index') }}" method="GET" class="support-order-search__form">
                                            <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                            <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search" aria-label="Search">
                                            <input class="search-btn-btn" type="submit" value="Search">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive custom-data-table-wrapper2">
                            <table class="table mb-0 table-borderless custom-data-table">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th><span class="userDatatable-title">SL</span></th>
                                        <th><span class="userDatatable-title">Type</span></th>
                                        <th><span class="userDatatable-title">Name</span></th>
                                        <th><span class="userDatatable-title">Incentive Amount</span></th>
                                        <th><span class="userDatatable-title">Created By</span></th>
                                        <th><span class="userDatatable-title">Created Date</span></th>
                                        <th><span class="userDatatable-title">Status</span></th>
                                        <th class="actions"><span class="userDatatable-title">Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($incentives as $key => $incentive)
                                    <tr>
                                        <td>{{ ($incentives->currentpage()-1) * $incentives->perpage() + $key + 1 }}</td>
                                        <td>
                                            @if($incentive->type == 'category')
                                                <span class="badge badge-success">Category Wise</span>
                                            @else
                                                <span class="badge badge-info">Model Wise</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                <strong>{{ $incentive->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                <strong>Tk {{ number_format($incentive->incentive_amount, 2) }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$incentive->creator->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($incentive->created_at)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject status-check">
                                                @if ($incentive->is_active)
                                                    <p style="background-color: #0e890e">Active</p>
                                                @else
                                                    <p style="background-color: #ff0000">Inactive</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(4))
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Change Status" href="{{ route('incentive-configuration.status', $incentive->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))
                                                <li>
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{ route('incentive-configuration.edit', $incentive->id) }}" class="edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No incentive configurations found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                            {{ $incentives->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryRadio = document.getElementById('type-category');
        const modelRadio = document.getElementById('type-model');
        const categorySelector = document.getElementById('category-selector');
        const modelSelector = document.getElementById('model-selector');
        const categorySelect = document.getElementById('select-category');
        const modelSelect = document.getElementById('select-model');

        function toggleSelectors() {
            if (categoryRadio.checked) {
                categorySelector.style.display = 'block';
                modelSelector.style.display = 'none';
                categorySelect.setAttribute('name', 'reference_id');
                categorySelect.required = true;
                modelSelect.removeAttribute('name');
                modelSelect.required = false;
                modelSelect.value = '';
            } else {
                categorySelector.style.display = 'none';
                modelSelector.style.display = 'block';
                modelSelect.setAttribute('name', 'reference_id');
                modelSelect.required = true;
                categorySelect.removeAttribute('name');
                categorySelect.required = false;
                categorySelect.value = '';
            }
        }

        categoryRadio.addEventListener('change', toggleSelectors);
        modelRadio.addEventListener('change', toggleSelectors);

        // Initialize on page load
        toggleSelectors();
    });
</script>

@endsection

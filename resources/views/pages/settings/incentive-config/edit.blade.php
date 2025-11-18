@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>Edit Incentive Configuration</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{ route('incentive-configuration.update', $incentive->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

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
                                        <!-- Type Display (Read-only) -->
                                        <div class="col-md-4 mb-25">
                                            <label class="form-label">Incentive Type</label>
                                            <input type="text" class="form-control" value="{{ ucfirst($incentive->type) }} Wise" readonly>
                                        </div>

                                        <!-- Name Display (Read-only) -->
                                        <div class="col-md-4 mb-25">
                                            <label class="form-label">
                                                @if($incentive->type == 'category')
                                                    Category Name
                                                @else
                                                    Product Model
                                                @endif
                                            </label>
                                            <input type="text" class="form-control" value="{{ $incentive->name }}" readonly>
                                        </div>

                                        <!-- Incentive Amount (Editable) -->
                                        <div class="col-md-4 mb-25">
                                            <label class="form-label">Incentive Amount (Tk) <span class="text-danger">*</span></label>
                                            <div class="with-icon">
                                                <input style="padding: 0 20px !important" required type="number" step="0.01" min="0" name="incentive_amount" value="{{ $incentive->incentive_amount }}" class="form-control px-2 ih-medium ip-lightradius-xs b-light" placeholder="Enter Amount">
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="col-md-12 form-basic pb-4">
                                            <button type="submit" class="btn btn-lg mb-4 btn-primary customr-btn btn-submit">Update Incentive</button>
                                            <a href="{{ route('incentive-configuration.index') }}" class="btn btn-lg btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

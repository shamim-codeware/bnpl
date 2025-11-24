@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            @if (Auth::user()->user_action(1))
                                <div class="card-header">
                                    <h6>Add Product Package</h6>
                                </div>
                                <div class="card-body py-md-30">
                                    <form action="{{ route('package.store') }}" method="post">
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
                                        <div class="form-group row mb-n25">
                                            <div class="col-md-4 mb-25">
                                                <div class="with-icon">
                                                    <input type="text" required name="name" class="form-control ih-medium ip-lightradius-xs b-light" placeholder="Package Name">
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-basic pb-4">
                                                <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Save</button>
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
    </div>
</div>
@endsection

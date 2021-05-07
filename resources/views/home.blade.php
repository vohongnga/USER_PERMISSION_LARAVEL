@extends('layouts.app')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="kt-portlet kt-portlet--mobile h-100">
            <div class="kt-portlet__body p-0 h-100">
                <div class="row h-100">
                    <div class="master-content-wrap col-12 h-100">
                        <div class="row justify-content-center align-items-center h-50">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">{{ __('Dashboard') }}</div>

                                    <div class="card-body">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        {{ __('You are logged in!') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

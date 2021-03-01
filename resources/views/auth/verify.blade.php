@extends('layouts.verify')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('') }}
                        </div>
                    @endif

                    {{ __('Enter the received code.') }}
                    <form class="d-inline" method="POST" action="{{ route('otp.verify') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="two_factor_pass" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Verify code') }}</button>
                        <button type="submit" form="resend-form" class="btn btn-secondary">{{ __('Resend code') }}</button>
                    </form>
                    <form id="resend-form" action="{{ route('otp.resend') }}" method="post">@csrf</form>
                    <div class="text-center">
                        @error('otp')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

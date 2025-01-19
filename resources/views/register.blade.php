@extends('layouts.app')

@section('title', 'Referral Register')

@section('content')
<div class="container content">
    <h1 class="text-center">{{ trans('referral::messages.referral.name') }}</h1>

    @if(session('success'))
        <div class="border p-3 my-2 bg-success text-white" style="border-radius: 15px; margin-bottom: 30px;">
            <h3> {!!\Illuminate\Support\Str::markdown(setting('referral.success_message'))!!} </h3>
        </div>
    @endif

    @if(!session('success'))
    @if($descMessage != '')
        <div class="border p-3 my-2 bg-primary text-white" style="border-radius: 15px;">
            <h5>{!! \Illuminate\Support\Str::markdown($descMessage) !!}</>
        </div>
    @endif

    @if($onlyAfterRegistration)
        <div class="border p-3 my-2 bg-danger text-white" style="border-radius: 15px;">
            <h4 class="text-center">{{trans('referral::messages.referral.register_advert')}}</h4>
        </div>
    @endif

    <form action="{{ route('referral.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="inputField">{{ trans('referral::messages.fields.nickname_input') }}</label>
            <input type="text" class="form-control" id="inputField" name="inputField" value="{{ old('inputField') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">{{trans('referral::messages.buttons.validate')}}</button>
    </form>
    @endif
</div>
@endsection

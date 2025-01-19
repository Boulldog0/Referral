@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('referral::messages.admin.titles.rewards'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('referral.admin.rewards.save') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="referramSwitch" name="enable_referral" data-bs-toggle="collapse" @checked($regivePercentage)>
                    <label class="form-check-label" for="referralSwitch">{{ trans('referral::messages.admin.rewards.enable_referrer_regive_percentage') }}</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="percentageInput">{{ trans('referral::messages.admin.rewards.percentage_title') }}</label>
                        <div class="input-group @error('goal') has-validation @enderror">
                            <input type="number" min="1" max="99" class="form-control @error('percentage') is-invalid @enderror" id="percentageInput" name="percentage" value="{{ old('percentage', $percentage) }}">
                            <span class="input-group-text">%</span>
                        @error('percentage')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="limitInput">{{ trans('referral::messages.admin.rewards.limit_title') }}</label>
                        <div class="input-group @error('goal') has-validation @enderror">
                            <input type="number" min="0" max="9999999" class="form-control @error('limit') is-invalid @enderror" id="limitInput" name="limit" value="{{ old('limit', $limit) }}">
                            <span class="input-group-text">{{ money_name() }}</span>
                        @error('limit')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
        <div class="border p-3 my-2 bg-danger text-white" style="border-radius: 15px;">
            <h2 class="text-center">⚠️{{trans('referral::messages.admin.rewards.planned_rewards')}}⚠️</h2>
            <h4 class="text-center">{{trans('referral::messages.admin.rewards.r')}}</h4>
        </div>
        </div>
    </div>
@endsection
@extends('admin.layouts.admin')

@section('title', trans('referral::messages.admin.package-links'))

@section('content')
<div class="container-fluid">
    <div class="alert alert-info d-flex align-items-center mb-4" role="alert" style="border-radius: 10px;">
        <i class="bi bi-info-circle-fill fs-3 me-3"></i>
        <div>
            <h5 class="alert-heading mb-1">{{ trans('referral::messages.admin.how-works') }}</h5>
            <p class="mb-0">
                {{ trans('referral::messages.admin.package-link-explanations') }}
            </p>
        </div>
    </div>

    <form action="{{ route('referral.admin.links.save') }}" method="POST">
        @csrf
        <div class="row g-3">
            @foreach($items as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm rounded p-3 h-100">
                        <div class="card-body p-0">
                            <label for="amount_{{ $item->id }}" class="form-label fw-bold mb-2">
                                <i class="bi bi-box-seam me-1"></i> {{ $item->name }} (ID: {{ $item->id }})
                            </label>
                            <div class="input-group mb-2">
                                <input type="number" step="0.01" min="0"
                                       class="form-control @error('amounts.' . $item->id) is-invalid @enderror"
                                       id="amount_{{ $item->id }}"
                                       name="amounts[{{ $item->id }}]"
                                       value="{{ old('amounts.' . $item->id, optional($links->firstWhere('shop_package_id', $item->id))->applied_amount ?? 0) }}">
                                <span class="input-group-text">{{ money_name() }}</span>
                                @error('amounts.' . $item->id)
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
            </button>
        </div>
    </form>
</div>
@endsection

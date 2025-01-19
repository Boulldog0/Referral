@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('referral::messages.admin.titles.settings'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            <form action="{{ route('referral.admin.settings.save') }}" method="POST">
                @csrf
                <div id="descMessage">
                    <div class="card card-body mb-3">
                        <div class="mb-0">
                            <label class="form-label" for="descMessage">{{ trans('referral::messages.admin.settings.description-title') }}</label>
                            <textarea class="form-control html-editor @error('desc_message') is-invalid @enderror" id="descMessage" name="desc_message" rows="5">{{ old('desc_message', $descMessage) }}</textarea>

                            @error('desc_message')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="enableReferralRegistrationOnlyAfterACreate" name="enable_referral" @checked($regOnlyACr)>
                    <label class="form-check-label" for="enableReferralRegistrationOnlyAfterACreate">{{ trans('referral::messages.admin.settings.enable_registr_only_acreate') }}</label>
                    <div id="moneyLabel" class="form-text">{{ trans('referral::messages.admin.settings.description_registration_set') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="expireInput">{{ trans('referral::messages.admin.settings.expire_title') }}</label>
                        <div class="input-group @error('goal') has-validation @enderror">
                            <input type="number" min="20" max="86400" class="form-control @error('expire') is-invalid @enderror" id="expireInput" name="expire" value="{{ old('expire', $registerExpireAfter) }}">
                            <span class="input-group-text">{{ trans('referral::messages.admin.seconds') }}</span>
                        @error('limit')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="sendNotification" name="send_notification" @checked($sendNotification)>
                    <label class="form-check-label" for="sendNotification">{{ trans('referral::messages.admin.settings.send_notification') }}</label>
                    <div id="notifSendLabel" class="form-text">{{ trans('referral::messages.admin.settings.description_send_notification') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="notificationInput">{{ trans('referral::messages.admin.settings.notification') }}</label>
                    <input type="text" class="form-control @error('notification') is-invalid @enderror" id="notificationInput" name="notification" value="{{ old('notification_content', $notifContent) }}">
                    @error('notification')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    <div id="notificationLabel" class="form-text">{{ trans('referral::messages.admin.settings.notification_placeholders') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="successMessage">{{ trans('referral::messages.admin.settings.success-title') }}</label>
                    <input type="text" class="form-control @error('success_message') is-invalid @enderror" id="successMessage" name="success_message" value="{{ old('success_message', $successMessage) }}">
                    @error('success_message')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="noReferrerInput">{{ trans('referral::messages.admin.settings.no-referrer') }}</label>
                    <input type="text" class="form-control @error('no_referrer') is-invalid @enderror" id="noReferrerInput" name="no_referrer" value="{{ old('no_referrer', $noReferrer) }}">
                    @error('no_referrer')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="noReferredInput">{{ trans('referral::messages.admin.settings.no-referred') }}</label>
                    <input type="text" class="form-control @error('no_referred') is-invalid @enderror" id="noReferredInput" name="no_referred" value="{{ old('no_referred', $noReferred) }}">
                    @error('no_referred')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>

            @if($user->can('referral.resetdb'))
                <form action="{{ route('referral.admin.settings.reset_db') }}" method="POST" id="regenForm">
                @csrf
                    <div class="mb-3">
                        <button type="submit" id="regen" class="btn btn-danger mt-3">
                            <i class="bi bi-arrow-clockwise"></i> {{ trans('referral::messages.admin.settings.reset_db') }}
                        </button>
                        <div id="resetDbLabel" class="form-text">{{ trans('referral::messages.admin.settings.reset_db_label') }}</div>
                    </div>
                    <script>
                        document.getElementById('regenForm').addEventListener('submit', function(event) {
                            const confirmAction = confirm('{{ trans('referral::messages.admin.confirm_db_regen') }}');
                            if(!confirmAction) {
                                event.preventDefault();
                            }
                        });
                    </script>
                </form>
            @endif
        </div>
    </div>
@endsection

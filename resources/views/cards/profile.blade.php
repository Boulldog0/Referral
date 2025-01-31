<div class="mb-3">
    @php
        use Illuminate\Support\Facades\Auth;
        use Azuriom\Models\User;
        use Azuriom\Plugin\Referral\Models\Referrals;

        $user = Auth::user();

        $tEarn = Referrals::where('referred_id', $user->id)->value('referrer_total_earn');
        $referrer = Referrals::where('referred_id', $user->id)->value('referrer_id');
        $referrerName = 'none';
        if($referrer !== null && $referrer !== 0) {
            $referrerName = User::find($referrer)->name;
        }
        $referreds = Referrals::where('referrer_id', $user->id)->get();
    @endphp

    <div class="mb-3">
        <label class="form-label" for="referrerName">{{ trans('referral::messages.profile.referrer_name') }}</label>
        @if($referrerName !== 'none')
            <input type="text" class="form-control" id="referrerName" name="referrer" value="{{ $referrerName }}" readonly>
            <div id="referrerLabel" class="form-text">{{ trans('referral::messages.profile.desc_referrer') }}</div>
            <div class="form-label">{{ trans('referral::messages.profile.total_referrer_earn') }} {{ $tEarn }} {{ money_name() }}</div>
        @else
            <h3 id="referrerName">{{ setting('referral.no_referrer') }}</h3>
            @if(!setting('referral.ereff'))
                <a class="btn btn-primary" href="">
                    <i class="bi bi-person-fill-add"></i>
                    {{ trans('referral::messages.profile.add_referrer') }}
                </a>
            @endif
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label" for="referredTable">{{ trans('referral::messages.profile.referred_users') }}</label>
        @if($referreds->isNotEmpty())
            <table class="table" id="referredTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('referral::messages.profile.username')}}</th>
                        <th>{{trans('referral::messages.profile.total_money_earn')}}</th>
                        <th>{{trans('referral::messages.profile.created_by_link')}}</th>
                        <th>{{trans('referral::messages.profile.referral_created_at')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referreds as $referred)
                        <tr>
                            <td>{{ $referred->id }}</td>
                            <td>{{ \Azuriom\Models\User::find($referred->referred_id)->name }}</td>
                            <td>{{ $referred->referrer_total_earn }} {{ money_name() }}</td>
                            <td>{{ $referred->created_via_link ? '✅' : '❌' }}</td>
                            <td>{{ $referred->created_at->translatedFormat('d/m/Y') }} {{ trans('referral::messages.admin.at') }} {{ $sponsor->created_at->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 id="referredTable">{{ setting('referral.no_referred') }}</h3>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label" for="referrerLink">{{ trans('referral::messages.profile.referrer_link') }}</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referrerLink" name="referrer" value="{{ url('/from/' . $user->name) }}" readonly>
            <button class="btn btn-outline-secondary" type="button" id="copyReferrerLink">
                <i class="bi bi-clipboard"></i>
            </button>
        </div>
        <div id="referrerLinkLabel" class="form-text">{{ trans('referral::messages.profile.desc_link') }}</div>
    </div>
    <script>
        document.getElementById('copyReferrerLink').addEventListener('click', function () {
            const referrerLink = document.getElementById('referrerLink');
            referrerLink.select();
            referrerLink.setSelectionRange(0, 99999);
            document.execCommand('copy');
        
            alert('{{ trans('referral::messages.profile.link_copied') }}');
        });
    </script>
</div>

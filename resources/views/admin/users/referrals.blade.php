<div class="card">
    <div class="card-body">
        <form action="{{ route('referral.admin.referrer.change', ['id' => $user->id]) }}" method="POST" id="referrerForm">
        @csrf
            <div class="mb-3">
            <label class="form-label" for="referrer">{{ trans('referral::messages.admin.referrer_name') }}</label>
            <input type="text" class="form-control" id="referrer" name="referrer" value="{{ $referrer === null ? '' : $referrer }}">
            <div id="label" class="form-text">{{ trans('referral::messages.admin.leave_blank_for_remove') }}</div>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </div>
    </form>
    <script>
        document.getElementById('referrerForm').addEventListener('submit', function(event) {
            const referrerInput = document.getElementById('referrer');
            if(!referrerInput.value.trim()) {
                const confirmAction = confirm('{{trans('referral::messages.admin.confirm_empty_referrer')}}');
                if(!confirmAction) {
                    event.preventDefault();
                }
            }
        });
    </script>

    <div class="mb-3">
        <label class="form-label" for="referrerLink">{{ trans('referral::messages.admin.referral_link') }}</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referrerLink" name="referrer" value="{{ url('/from/' . $user->name) }}" readonly>
            <button class="btn btn-outline-secondary" type="button" id="copyReferrerLink">
                <i class="bi bi-clipboard"></i>
            </button>
        </div>
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


        <div class="mb-3">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-body">
                        <label for="referredTable">{{ trans('referral::messages.admin.referreds') }}</label>
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
                                @foreach ($referreds as $referred)
                                    <tr>
                                        <td>{{ $referred->id }}</td>
                                        <td><a href="{{ url('/admin/users/' . $referred->referred_id . '/edit') }}">{{ \Azuriom\Models\User::find($referred->referred_id)->name }}</a></td>
                                        <td>{{ $referred->referrer_total_earn }} {{ money_name() }}</td>
                                        <td>{{ $referred->created_via_link ? '✅' : '❌' }}</td>
                                        <td>{{ format_date($referred->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-body">
                        <label for="rewards">{{ trans('referral::messages.admin.rew') }}</label>
                        <table class="table" id="rewards">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>{{trans('referral::messages.admin.history.total_price')}}</th>
                                <th>{{trans('referral::messages.admin.money_receive')}}</th>
                                <th>{{trans('referral::messages.admin.percentage_receive')}}</th>
                                <th>{{trans('referral::messages.admin.history.referred')}}</th>
                                <th>{{trans('referral::messages.admin.history.date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewards as $reward)
                                <tr>
                                    <td>{{ $reward->id }}</td>
                                    <td>{{ $reward->total_amount }} {{money_name()}}</td>
                                    <td>{{ $reward->given_amount }} {{money_name()}}</td>
                                    <td>{{ $reward->percentage_given }}%</td>
                                    <td><a href="{{ url('/admin/users/' . $reward->user_id . '/edit') }}">{{ \Azuriom\Models\User::find($reward->user_id)->name }}</a></td>
                                    <td>{{ format_date($reward->created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-body">
                        <label for="rewardsGiven">{{ trans('referral::messages.admin.given') }}</label>
                        <table class="table" id="rewardsGiven">
                             <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('referral::messages.admin.history.referrer')}}</th>
                                    <th>{{trans('referral::messages.admin.history.total_price')}}</th>
                                    <th>{{trans('referral::messages.admin.history.money_given')}}</th>
                                    <th>{{trans('referral::messages.admin.history.p_given')}}</th>
                                    <th>{{trans('referral::messages.admin.history.date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($buyings as $transaction)
                                    <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td><a href="{{ url('/admin/users/' . $transaction->referrer_id . '/edit') }}">{{ \Azuriom\Models\User::find($transaction->referrer_id)->name }}</a></td>
                                    <td>{{ $transaction->total_amount }} {{money_name()}}</td>
                                    <td>{{ $transaction->given_amount }} {{money_name()}}</td>
                                    <td>{{ $transaction->percentage_given }}%</td>
                                    <td>{{ format_date($transaction->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
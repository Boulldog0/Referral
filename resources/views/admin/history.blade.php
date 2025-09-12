@extends('admin.layouts.admin')

@section('title', trans('referral::messages.admin.titles.history'))

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('referral::messages.admin.history.referrer')}}</th>
                        <th>{{trans('referral::messages.admin.history.total_price')}}</th>
                        <th>{{trans('referral::messages.admin.history.money_given')}}</th>
                        <th>{{trans('referral::messages.admin.history.p_given')}}</th>
                        <th>{{trans('referral::messages.admin.history.referred')}}</th>
                        <th>{{trans('referral::messages.admin.history.date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        @php
                            $referrer = \Azuriom\Models\User::where('id', $transaction->referrer_id)->first();
                            $referred = \Azuriom\Models\User::where('id', $transaction->user_id)->first();
                            $referrerName = $referrer ? $referrer->name : 'Unknown (User Deleted #' . $transaction->referrer_id . ')';
                            $referredName = $referred ? $referred->name : 'Unknown (User Deleted #' . $transaction->referred_id . ')';            
                        @endphp
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td><a href="{{ url('/admin/users/' . $transaction->referrer_id . '/edit') }}">{{ $referrerName }}</a></td>
                            <td>{{ $transaction->total_amount }} {{money_name()}}</td>
                            <td>{{ $transaction->given_amount }} {{money_name()}}</td>
                            <td>{{ $transaction->percentage_given }}%</td>
                            <td><a href="{{ url('/admin/users/' . $transaction->user_id . '/edit') }}">{{ $referredName }}</a></td>
                            <td>{{ format_date($transaction->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

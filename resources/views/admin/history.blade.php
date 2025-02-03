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
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td><a href="{{ url('/admin/users/' . $transaction->referrer_id . '/edit') }}">{{ $transaction->referrer_username }}</a></td>
                            <td>{{ $transaction->total_amount }} {{money_name()}}</td>
                            <td>{{ $transaction->given_amount }} {{money_name()}}</td>
                            <td>{{ $transaction->percentage_given }}%</td>
                            <td><a href="{{ url('/admin/users/' . $transaction->user_id . '/edit') }}">{{ $transaction->username }}</a></td>
                            <td>{{ format_date($transaction->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

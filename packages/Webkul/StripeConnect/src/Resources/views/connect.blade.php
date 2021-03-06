@extends('admin::layouts.content')

@section('page_title')
    Connect Stripe Account
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>Connect Your RazzoPay Account</h1>
            </div>
            <div class="page-action">
            </div>
        </div>

        <div class="page-content">
            @if (env('STRIPE_CLIENT_ID'))
                @inject('stripeConnect', 'Webkul\StripeConnect\Repositories\StripeConnectRepository')

                @if($stripeConnect->findWhere(['company_id' => \Company::getCurrent()->id])->count() == 0)
                    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{  env('STRIPE_CLIENT_ID') }}&stripe_landing=register&scope=read_write&redirect_uri={{ route('admin.stripe.retrieve-grant') }}" class="btn btn-lg btn-primary">{{ __('stripe::app.connect-stripe') }}</a>
                @else
                    <a href="{{ route('admin.stripe.revoke-access') }}" class="btn btn-lg btn-primary">{{ __('stripe::app.revoke-access') }}</a>
                @endif
            @else
                <span class="warning" style="font-size: 18px; font-weight: bold; color: #556cd6">
                    {{ __('stripe::app.client-id-missing') }}
                    <br/><br/>
                    <a href="{{ route('admin.configuration.index', 'stripe') }}">{{ __('stripe::app.click-here') }}</a>
                </span>
            @endif
        </div>
    </div>
@stop
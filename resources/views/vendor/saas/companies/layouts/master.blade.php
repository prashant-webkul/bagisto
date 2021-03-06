@php
    $logo = $favicon = null;

    $matter = app('Webkul\SAASCustomizer\Models\SuperAdmin');

    $matter = $matter->all();

    if ($matter->count()) {
        $images = $matter->first();

        $images = json_decode($images->misc);

        if (isset($images) && $images != "") {
            if (isset($images->logo)) {
                $logo = $images->logo;
            }

            if (isset($images->favicon)) {
                $favicon = $images->favicon;
            }
        }
    }
@endphp

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>@yield('page_title')</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (isset($favicon))
            <link rel="icon" sizes="16x16" href="{{ asset('storage/'.$favicon) }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('vendor/webkul/custom/assets/images/razzo.png') }}" />
        @endif

        <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/saas/assets/css/saas.css') }}">

        @yield('head')

        @yield('css')

        {!! view_render_event('bagisto.admin.layout.head') !!}

    </head>

    <body @if (app()->getLocale() == 'ar') class="rtl" @endif style="scroll-behavior: smooth;">
        <div id="app">
            {!! view_render_event('bagisto.saas.body.before') !!}

            <flash-wrapper ref='flashes'></flash-wrapper>

            @include ('saas::companies.layouts.nav-top')

            @auth('super-admin')
                @include ('saas::companies.layouts.nav-left')
            @endauth

            <div class="content-container">
                @yield('content-wrapper')
            </div>
        </div>

        <script type="text/javascript">
            window.flashMessages = [];

            @if ($success = session('success'))
                window.flashMessages = [{'type': 'alert-success', 'message': "{{ $success }}" }];
            @elseif ($warning = session('warning'))
                window.flashMessages = [{'type': 'alert-warning', 'message': "{{ $warning }}" }];
            @elseif ($error = session('error'))
                window.flashMessages = [{'type': 'alert-error', 'message': "{{ $error }}" }];
            @elseif ($info = session('info'))
                window.flashMessages = [{'type': 'alert-error', 'message': "{{ $info }}" }];
            @endif

            window.serverErrors = [];

            @if (isset($errors))
                @if (count($errors))
                    window.serverErrors = @json($errors->getMessages());
                @endif
            @endif
        </script>

        <script type="text/javascript" src="{{ asset('vendor/webkul/admin/assets/js/admin.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}"></script>

        @stack('scripts')

        <div class="modal-overlay"></div>

        {!! view_render_event('bagisto.saas.body.after') !!}
    </body>
</html>
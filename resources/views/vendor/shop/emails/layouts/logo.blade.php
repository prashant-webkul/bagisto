@if ($logo = core()->getCurrentChannel()->logo_url)
    <img class="logo" src="{{ $logo }}" />
@else
    {{-- <img src="{{ asset('vendor/webkul/custom/assets/images/razzo.png') }}" alt="Razzo"/> --}}
    <span>{{ \Company::getCurrent()->name }}</span>
@endif
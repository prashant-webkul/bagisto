<?php

$creditMax = app('Webkul\CustomerCreditMax\Repositories\CustomerCreditMaxRepository');

$creditMax = $creditMax->findWhere(['customer_id' => $customer->id]);

?>

@section('css')
    @parent

    <style>
        .modal-container {
            top: 20px !important;
        }
    </style>
@stop

<accordian :title="'Credit Max'" :active="true">
    <div slot="body">

        <button type="button" style="margin-bottom : 20px" class="btn btn-md btn-primary" @click="showModal('showCreditMax')">
            Credit Max
        </button>
    </div>
</accordian>

@php
    $creditMax = app('Webkul\CustomerCreditMax\Repositories\CustomerCreditMaxRepository')->findOneWhere([
        'customer_id' => $customer->id
    ]);
@endphp

<modal id="showCreditMax" :is-open="modalIds.showCreditMax">
    <h3 slot="header">Specify / Check limit</h3>

    <div slot="body">
        <form method="POST" action="{{ route('customer.creditmax.sync', $customer->id) }}" @submit.prevent="onSubmit">
            @csrf()

            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

            <div class="control-group" :class="[errors.has('limit') ? 'has-error' : '']">
                <label for="limit">{{ __('Credit Max') }}</label>

                <input type="number" class="control" id="limit" name="limit" data-vv-as="&quot;{{ __('Credit Max') }}&quot;" value="{{ isset($creditMax) ? $creditMax->limit : old('limit') }}"/
                >

                <span class="control-error" v-if="errors.has('limit')">@{{ errors.first('limit') }}</span>
            </div>

            <input type="submit" class="btn btn-md btn-primary" value="Save Credit Max">
        </form>
    </div>
</modal>
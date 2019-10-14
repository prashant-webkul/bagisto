@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.promotion.add-catalog-rule') }}
@stop

@section('content')
    <div class="content">
        <catalog-rule></catalog-rule>
    </div>

    @push('scripts')
        <script type="text/x-template" id="catalog-rule-form-template">
            <div>
                <form method="POST" action="{{ route('admin.catalog-rule.store') }}" @submit.prevent="onSubmit">
                    @csrf

                    <div class="page-header">
                        <div class="page-title">
                            <h1>
                                <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

                                {{ __('admin::app.promotion.add-catalog-rule') }}
                            </h1>
                        </div>

                        <div class="page-action">
                            <button type="submit" class="btn btn-lg btn-primary">
                                {{ __('admin::app.promotion.save-btn-title') }}
                            </button>
                        </div>
                    </div>

                    <div class="page-content">
                        <div class="form-container">
                            @csrf()

                            <accordian :active="true" title="{{ __('admin::app.promotion.conditions') }}">
                                <div slot="body">
                                    <input type="hidden" name="all_conditions" v-model="all_conditions">

                                    <div class="control-container mb-10">
                                        <span>If&nbsp;</span>

                                        <select class="control" style="width: 70px; padding:0; margin: 0;">
                                            <option>ALL</option>
                                            <option>ANY</option>
                                        </select>

                                        &nbsp;

                                        <span>conditions&nbsp;</span>

                                        <select class="control" style="width: 70px; padding:0; margin: 0;">
                                            <option>TRUE</option>
                                            <option>FALSE</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-primary btn-sm mb-10" v-on:click="handleAddCondition">+</button>

                                    <div v-if="conditionInitiated">
                                        <div>{</div>

                                            <div class="control-container" v-for="(conditionObject, index) in allconditions" :key="index" style="margin-left: 15px;" v-if="conditionObject.typeof != 'array'">
                                                <div class="control-group" :class="[errors.has('allconditions[index].attribute') ? 'has-error' : '']" style="width: 180px;">
                                                    <select class="control" v-validate="'required|numeric'" v-model="allconditions[index].attribute" name="attribute" data-vv-as="&quot;{{ __('admin::app.attribute') }}&quot;" v-on:change="handleAttribute">
                                                        @foreach ($catalog_rule['attributes'] as $attribute)
                                                            <option value="{{ $attribute['id'] }}">{{ $attribute['name'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    <span class="control-error" v-if="errors.has('allconditions[index].attribute')">@{{ errors.first('allconditions[index].attribute') }}</span>
                                                </div>

                                                <div class="control-group" :class="[errors.has('allconditions[index].condition') ? 'has-error' : '']" style="width: 180px;" v-if="attributeHandled" v-on:click="handleCondition">
                                                    <select class="control" v-model="allconditions[index].condition" v-validate="'required'" name="condition" data-vv-as="&quot;{{ __('admin::app.condition') }}&quot;">
                                                        <option>{{ __('admin::app.select-attribute', ['attribute' => 'Condition']) }}</option>
                                                        @foreach ($catalog_rule['config']['conditions']['string'] as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>

                                                    <span class="control-error" v-if="errors.has('allconditions[index].condition')">@{{ errors.first('allconditions[index].condition') }}</span>
                                                </div>

                                                <div class="control-group" :class="[errors.has('allconditions[index].value') ? 'has-error' : '']" style="width: 180px;" v-if="conditionHandled" v-on:click="handleValue">
                                                    <input type="text" class="control" v-model="allconditions[index].value" v-validate="'required'" name="value" data-vv-as="&quot;{{ __('admin::app.value') }}&quot;">

                                                    <span class="control-error" v-if="errors.has('allconditions[index].value')">@{{ errors.first('allconditions[index].value') }}</span>
                                                </div>

                                                <div class="control-group" style="width: auto;">
                                                    <select class="btn btn-sm" v-model="allconditions[index].conjecture" v-validate="'required'" v-if="allconditions.length" style="margin-right: 10px; color: grey;">
                                                        <option value="&">AND</option>
                                                        <option value="!&">NAND</option>
                                                        <option value="!||">NOR</option>
                                                        <option valye="!">NOT</option>
                                                        <option value="||">OR</option>
                                                    </select>
                                                </div>

                                                <button class="btn btn-sm" v-on:click="nest(index)" v-if="allconditions.length > 1 && index != 0" style="margin-right: 10px; color: grey;">Nest</button>

                                                {{-- <button class="btn btn-sm btn-danger" v-on:click="deNext(index)">De-nest</button> --}}

                                                <button class="btn btn-smx" v-on:click="removeConditionObject(index)"><span class="icon trash-icon"></span></button>
                                            </div>

                                        <div>}</div>
                                    </div>
                                </div>
                            </accordian>
                        </div>
                    </div>
                </form>
            </div>
        </script>

        <script>
            Vue.component('catalog-rule', {
                template: '#catalog-rule-form-template',

                inject: ['$validator'],

                data () {
                    return {
                        all_conditions: null,
                        allconditions: [],
                        criteria: 'cart',
                        attribute: null,
                        condition: null,
                        value: null,
                        conditionInitiated: false,
                        conditionHandled: false,
                        attributeHandled: false,
                        valueHandled: false
                    }
                },

                mounted () {
                },

                methods: {
                    categoryLabel (option) {
                        return option.name + ' [ ' + option.slug + ' ]';
                    },

                    attributeListLabel(option) {
                        return option.label;
                    },

                    handleAddCondition (event) {
                        event.preventDefault();

                        this.conditionInitiated = true;

                        conditionObject = {
                            'attribute': null,
                            'condition': null,
                            'value': null,
                            'conjecture': 'or'
                        };

                        this.allconditions.push(conditionObject);

                        conditionObject.attribute = null;
                        conditionObject.condition = null;
                        conditionObject.value = null;
                        conditionObject.conjecture = null;
                    },

                    handleAttribute() {
                        this.attributeHandled = true;
                    },

                    handleCondition() {
                        this.conditionHandled = true;
                    },

                    handleValue() {
                        this.valueHandled = true;
                    },

                    nest(index) {
                        event.preventDefault();

                        temp = this.allconditions[index];

                        obj = [];

                        obj.push(temp);

                        this.allconditions[index] = obj;

                        console.log(index);
                    },

                    removeConditionObject(index) {
                        removedObject = this.allconditions.splice(index, 1);

                        console.log(removedObject);
                    }
                }
            });
        </script>
    @endpush
@stop
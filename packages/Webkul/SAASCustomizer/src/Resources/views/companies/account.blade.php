@extends('saas::companies.layouts.master')

@section('page_title')
    Manage Account
@stop

@section('content-wrapper')
    <div class="content">
        <form method="POST" action="{{ route('super.admin.update') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        Manage Account
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.users.users.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="container">
                    @csrf()

                    <accordian :title="'General'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <label for="email" class="required">{{ __('saas::app.account.email') }}</label>
                                <input type="text" v-validate="'required|email'" class="control" id="email" name="email" data-vv-as="&quot;{{ __('saas::app.account.email') }}&quot;" value="{{ $super->email }}" />
                                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                            </div>

                            @php
                                if (isset($super->misc)) {
                                    $images = json_decode($super->misc);
                                }
                            @endphp

                            <div class="control-group">
                                <label>{{ __('admin::app.settings.channels.logo') }}

                                <image-wrapper :button-label="'{{ __('admin::app.catalog.products.add-image-btn-title') }}'" input-name="logo" :multiple="false" @if (isset($images->logo)) :images='"{{ asset('storage/'.$images->logo) }}"' @endif></image-wrapper>
                            </div>

                            <div class="control-group">
                                <label>{{ __('admin::app.settings.channels.favicon') }}

                                <image-wrapper :button-label="'{{ __('admin::app.catalog.products.add-image-btn-title') }}'" input-name="favicon" :multiple="false" @if (isset($images->favicon)) :images='"{{ asset('storage/'.$images->favicon) }}"' @endif></image-wrapper>
                            </div>
                        </div>
                    </accordian>

                    <accordian :title="'{{ __('saas::app.account.password') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('old_password') ? 'has-error' : '']">
                                <label for="password">{{ __('saas::app.account.password') }}</label>
                                <input type="password" v-validate="'required|min:6|max:18'" class="control" id="old_password" name="old_password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('old_password')">@{{ errors.first('old_password') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                                <label for="password">{{ __('saas::app.account.password') }}</label>
                                <input type="password" v-validate="'min:6|max:18'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('saas::app.account.password') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                                <label for="password_confirmation">{{ __('saas::app.account.confirm-password') }}</label>
                                <input type="password" v-validate="'min:6|max:18|confirmed:password'" class="control" id="password_confirmation" name="password_confirmation" data-vv-as="&quot;{{ __('saas::app.account.confirm-password') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</span>
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@stop
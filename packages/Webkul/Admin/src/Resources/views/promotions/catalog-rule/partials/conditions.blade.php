<div v-if="conditionInitiated">
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

        <button class="btn btn-smx" v-on:click="removeConditionObject(index)"><span class="icon trash-icon"></span></button>
    </div>
</div>
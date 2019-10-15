<template>
    <div>
        <div class="selection-groups" v-for="(sub_selection, i) in sub_selections" :key="i">
            <div class="control-container mb-10">
                <span>If&nbsp;</span>

                <select class="control" v-model="sub_selections[i].condition" style="width: 70px; padding:0; margin: 0;">
                    <option value="all">All</option>
                    <option value="any">Any</option>
                </select>

                &nbsp;

                <span>conditions&nbsp;</span>

                <select class="control" v-model="sub_selections[i].test" style="width: 70px; padding:0; margin: 0;">
                    <option value=1>True</option>
                    <option value=0>False</option>
                </select>
            </div>

            <div v-if="sub_selections[i].subSelectionInitiated">
                @include('admin::promotions.catalog-rule.partials.condition-maker')
            </div>

            <div v-if="sub_selections[i].categories">
                @include('admin::promotions.catalog-rule.partials.category')
            </div>

            <div v-if="sub_selections[i].attribute_family">
                @include('admin::promotions.catalog-rule.partials.attribute-family')
            </div>

            <button class="btn btn-primary btn-sm mb-10" v-on:click="handleAddCondition(i)" v-if="sub_selections[i].toggleAdd">+</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'condition-wrapper',

        props: {
            attributeFamilies: {
                type: String,
                required: true,
                default: () => [],
            },

            categories: {
                type: String,
                required: true,
                default: () => [],
            }
        },

        data () {
            return {
                handleCalled: 0,
                basic: {
                    'condition': 'all',
                    'test': 1,
                    'subSelectionInitiated': false,
                    'toggleAdd': true,
                    'type_selection': null,
                    'hide_type_selection': false,
                    'attribute_family': false,
                    'categories': false,
                    'combine': false
                },

                sub_selections: [],

                all_conditions: null,

                allconditions: [],

                // criteria: 'cart',
                // attribute: null,
                // condition: null,
                // value: null,
                // conditionInitiated: false,
                // conditionHandled: false,
                // attributeHandled: false,
                // valueHandled: false
            };
        },

        mounted () {
            this.sub_selections.push(this.basic);

            console.log(this.categories);
        },

        methods: {
            categoryLabel (option) {
                return option.name + ' [ ' + option.slug + ' ]';
            },

            attributeListLabel(option) {
                return option.label;
            },

            handleAddCondition (index) {
                event.preventDefault();

                if (this.handleCalled == 0) {
                    this.sub_selections[index].subSelectionInitiated = true;

                    this.sub_selections[index].toggleAdd = false;
                } else {
                    this.basic = {
                        'condition': 'all',
                        'test': 1,
                        'subSelectionInitiated': false,
                        'toggleAdd': true,
                        'type_selection': null,
                        'hide_type_selection': false,
                        'attribute_family': false,
                        'categories': false,
                        'combine': false
                    };

                    this.sub_selections.push(this.basic);
                }

                this.handleCalled++;

                // this.conditionInitiated = true;

                // conditionObject = {
                //     'attribute': null,
                //     'condition': null,
                //     'value': null,
                //     'conjecture': 'or'
                // };

                // this.allconditions.push(conditionObject);

                // conditionObject.attribute = null;
                // conditionObject.condition = null;
                // conditionObject.value = null;
                // conditionObject.conjecture = null;
            },

            handleTypeSelection(index) {
                this.sub_selections[index].toggleAdd = true;

                this.sub_selections[index].hide_type_selection = true;

                if (this.sub_selections[index].type_selection == 'category') {
                    this.sub_selections[index].categories = true;

                    this.sub_selections[index].hide_category = false;
                } else if (this.sub_selections[index].type_selection == 'attribute_family') {
                    this.sub_selections[index].attribute_family = true;

                    this.sub_selections[index].hide_attribute_family = false;
                }
                // else {

                // }
            },

            handleAttribute() {
                this.attributeHandled = true;
            },

            handleCondition() {
                this.conditionHandled = true;
            },

            handleAttributeFamilyChange(index) {
                this.sub_selections[index].hide_attribute_family = true;
            },

            handleCategoryChange(index) {
                this.sub_selections[index].hide_category = true;
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
    }
</script>
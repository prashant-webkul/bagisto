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

                <select class="control" v-model="sub_selections[i].test" style="width: 70px; padding: 0; margin: 0;">
                    <option value=1>True</option>
                    <option value=0>False</option>
                </select>
            </div>

            <div v-if="subSelectionInitiated">
                <div class="control-group" v-if="! sub_selections[i].hide_type_selection">
                    <select class="control" v-model="sub_selections[i].type_selection" v-on:change="handleTypeSelection(i)">
                        <option value="combine">Combine Conditions</option>
                        <optgroup label="Select Option">
                            <option value="attribute_family">Attribute Family</option>
                            <option value="category">Category</option>
                        </optgroup>
                    </select>
                </div>

                <span v-if="sub_selections[i].hide_type_selection"><b>{{ sub_selections[i].type_selection }}</b> is</span>
            </div>

            <div v-if="sub_selections[i].categories">
                <div class="control-group" v-if="! sub_selections[i].hide_category">
                    <select class="control" v-model="sub_selections[i].category" v-on:change="handleCategoryChange(i)">
                        <option v-for="(category, catIndex) in categories" :key="catIndex" v-bind:value="category.id">
                            {{ category.slug }}
                        </option>
                    </select>
                </div>

                <span v-if="sub_selections[i].hide_category">
                    <b v-for="category in categories" v-if="category.id == sub_selections[i].category">{{ category.name }}</b>
                </span>
            </div>

            <div v-if="sub_selections[i].attribute_family">
                <div class="control-group" v-if="! sub_selections[i].hide_attribute_family">
                    <select class="control" v-model="sub_selections[i].family" v-on:change="handleAttributeFamilyChange(i)">
                        <option v-for="(attributeFamily, famIndex) in attributeFamilies" :key="famIndex" v-bind:value="attributeFamily.id">
                            {{ attributeFamily.name }}
                        </option>
                    </select>
                </div>

                <span v-if="sub_selections[i].hide_attribute_family">
                    <b v-for="attributeFamily in attributeFamilies" v-if="attributeFamily.id == sub_selections[i].family">{{ attributeFamily.name }}</b>
                </span>
            </div>

            <button class="btn btn-primary btn-sm mb-10" v-on:click="handleAddCondition(i)" v-if="sub_selections[i].toggleAdd">+</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'condition-wrapper',

        props: {
            attributeFams: {
                type: String,
                required: true,
                default: () => [],
            },

            cats: {
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
                    'toggleAdd': true,
                    'type_selection': null,
                    'hide_type_selection': false,
                    'attribute_family': false,
                    'categories': false,
                    'combine': false
                },

                subSelectionInitiated: false,

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

            this.categories = JSON.parse(this.cats);

            this.attributeFamilies = JSON.parse(this.attributeFams);
        },

        methods: {
            handleAddCondition (index) {
                event.preventDefault();

                this.subSelectionInitiated = true;
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
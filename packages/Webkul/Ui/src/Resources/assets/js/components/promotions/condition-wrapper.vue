<template>
    <div>
        <div class="selection-groups" v-for="(sub_selection, i) in sub_selections" :key="i">
            <div class="control-container mb-10">
                <span>If&nbsp;</span>

                <select class="control" v-model="sub_selections[i].condition" style="width: 70px; padding:0; margin: 0;" v-on:change="hideConditionFactor" v-if="! conditionFactorToggle">
                    <option value="all">All</option>
                    <option value="any">Any</option>
                </select>

                <span v-on:click="hideConditionFactor" v-if="conditionFactorToggle"><b class="uppercase">{{ sub_selections[i].condition }}</b></span>

                &nbsp;

                <span>
                    conditions
                    <span v-if="sub_selections[i].condition == 'all'">are&nbsp;</span>
                    <span v-else>is&nbsp;</span>
                </span>

                <select class="control" v-model="sub_selections[i].test" style="width: 70px; padding: 0; margin: 0;" v-on:change="hideTestFactor" v-if="! testFactorToggle">
                    <option value=1>True</option>
                    <option value=0>False</option>
                </select>

                <span v-on:click="hideTestFactor" v-if="testFactorToggle">
                    <b class="uppercase" v-if="sub_selections[i].test == 1">True</b>
                    <b class="uppercase" v-if="sub_selections[i].test == 0">False</b>
                </span>

                <span class="icon trash-icon uppercase"></span>
            </div>

            <div class="control-container mb-20" v-for="(innerCategories, innerCatIndex) in sub_selections[i].categories">
                <span>Category is&nbsp;</span>

                <select class="control" v-model="sub_selections[i].categories[innerCatIndex].value" style="width: 120px; padding: 0; margin: 0;" v-on:change="hideCategoryFactor(i, innerCatIndex)" v-if="! sub_selections[i].categories[innerCatIndex].hideInput">
                    <option v-for="(category, catIndex) in categories" :key="catIndex" v-bind:value="category.id">
                        {{ category.slug }}
                    </option>
                </select>

                <span class="uppercase" v-on:click="hideCategoryFactor(i, innerCatIndex)" v-if="sub_selections[i].categories[innerCatIndex].hideInput">
                    <b>{{ sub_selections[i].categories[innerCatIndex].value }}</b>
                </span>

                <span class="small-remove-icon uppercase ml-5" v-on:click="removeCategory(i)"></span>
            </div>

            <div class="control-container mb-20" v-for="(innerAttributeFamilies, innerFamIndex) in sub_selections[i].attribute_families">
                <span>Attribute family is&nbsp;</span>

                <select class="control" v-model="sub_selections[i].attribute_families[innerFamIndex].value" style="width: 120px; padding: 0; margin: 0;" v-on:change="hideAttributeFamilyFactor(i, innerFamIndex)" v-if="! sub_selections[i].attribute_families[innerFamIndex].hideInput">
                    <option v-for="(attributeFamily, famIndex) in attribute_families" :key="famIndex" v-bind:value="attributeFamily.id">
                        {{ attributeFamily.name }}
                    </option>
                </select>

                <span class="uppercase" v-on:click="hideAttributeFamilyFactor(i, innerFamIndex)" v-if="sub_selections[i].attribute_families[innerFamIndex].hideInput">
                    <b>{{ sub_selections[i].attribute_families[innerFamIndex].value }}</b>
                </span>

                <span class="small-remove-icon uppercase ml-5" v-on:click="removeAttributeFamily(i)"></span>
            </div>

            <div v-if="require_type_of_selection">
                <div class="control-group" v-if="! sub_selections[i].hide_type_selection">
                    <select class="control" v-model="sub_selections[i].type_selection" v-on:change="handleTypeSelection(i)" style="width: 120px; padding: 0; margin: 0;">
                        <option value="combine">Combine Conditions</option>

                        <optgroup label="Select Option">
                            <option value="attribute_family">Attribute Family</option>
                            <option value="category">Category</option>
                        </optgroup>
                    </select>
                </div>

                <span v-if="sub_selections[i].hide_type_selection"><b>{{ sub_selections[i].type_selection }}</b> is</span>
            </div>

            <div style="margin-left: 20px;">
                <condition-wrapper :attributeFams='attributeFams' :cats='cats' v-for="(combine, combIndex) in sub_selections[i].combine" @click="childClicked(combIndex)"></condition-wrapper>
            </div>

            <span class="row mt-10" v-on:click="insertCondition(i)" v-if="toggleAdd"><span class="small-add-icon"></span>&nbsp;Inline Condition</span>
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
                default: () => []
            },

            cats: {
                type: String,
                required: true,
                default: () => []
            }
        },

        data () {
            return {
                global: [],
                handleCalled: 0,

                conditionFactorToggle: false,
                testFactorToggle: false,

                attributeFamilyToggle: true,

                categoryToggle: true,

                basic: {
                    'condition': 'all',
                    'test': 1,
                    'toggleAdd': true,
                    'type_selection': null,
                    'attribute_families': [],
                    'categories': [],
                    'combine': []
                },

                categories: [],
                attribute_families: [],
                sub_selections: [],
                require_type_of_selection: false,
                toggleAdd: true,
                temp: []
            };
        },

        mounted () {
            this.sub_selections.push(this.basic);

            this.categories = JSON.parse(this.cats);

            this.attribute_families = JSON.parse(this.attributeFams);

            this.conditionFactorToggle = true;

            this.testFactorToggle = true;
        },

        methods: {
            insertCondition: function (index) {
                event.preventDefault();

                this.toggleAdd = false;

                this.require_type_of_selection = true;
            },

            handleTypeSelection: function (index) {
                this.toggleAdd = true;

                // this.sub_selections[index].hide_type_selection = true;

                if (this.sub_selections[index].type_selection == 'category') {
                    this.sub_selections[index].categories.push({
                        'value': null,
                        'hideInput': false
                    });
                } else if (this.sub_selections[index].type_selection == 'attribute_family') {
                    this.sub_selections[index].attribute_families.push({
                        'value': null,
                        'hideInput': false
                    });
                } else {


                    this.sub_selections[index].combine.push({
                        'condition': 'all',
                        'test': 1,
                        'toggleAdd': true,
                        'type_selection': null,
                        'attribute_families': [],
                        'categories': [],
                        'combine': []
                    });
                }

                this.sub_selections[index].type_selection = null;

                this.require_type_of_selection = false;
            },

            hideConditionFactor: function () {
                if (this.conditionFactorToggle == false) {
                    this.conditionFactorToggle = true;
                } else {
                    this.conditionFactorToggle = false;
                }
            },

            hideTestFactor: function() {
                if (this.testFactorToggle == false) {
                    this.testFactorToggle = true;
                } else {
                    this.testFactorToggle = false;
                }
            },

            hideAttributeFamilyFactor: function (subSelectionIndex, attributeFamilyIndex) {
                if (this.sub_selections[subSelectionIndex].attribute_families[attributeFamilyIndex].hideInput) {
                    this.sub_selections[subSelectionIndex].attribute_families[attributeFamilyIndex].hideInput = false;
                } else {
                    this.sub_selections[subSelectionIndex].attribute_families[attributeFamilyIndex].hideInput = true;
                }
            },

            hideCategoryFactor: function (subSelectionIndex, categoryIndex) {
                if (this.sub_selections[subSelectionIndex].categories[categoryIndex].hideInput) {
                    this.sub_selections[subSelectionIndex].categories[categoryIndex].hideInput = false;
                } else {
                    this.sub_selections[subSelectionIndex].categories[categoryIndex].hideInput = true;
                }
            },

            removeCategory: function (index) {
                this.sub_selections[index].categories.splice(index, 1);
            },

            removeAttributeFamily: function (index) {
                this.sub_selections[index].attribute_families.splice(index, 1);
            },

            childClicked: function (value) {
                console.log(value);
            }
        }
    }
</script>

<style>
    .uppercase {
        cursor: pointer;
        text-transform: uppercase;
        text-decoration: underline;
    }

    .ml-5 {
        margin-left: 5px;
    }

    .selection-groups {
        border-left: 2px dotted #A2A2A2;
    }

    span.row {
        justify-content: flex-start;
        align-items: center;
        cursor: pointer;
    }
</style>
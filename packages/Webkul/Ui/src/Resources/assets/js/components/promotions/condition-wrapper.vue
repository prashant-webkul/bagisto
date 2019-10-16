<template>
    <div>
        <div class="selection-groups" v-for="(sub_selection, i) in sub_selections" :key="i" style="border-left: 1px dotted #c7c7c7;">
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

            <div class="control-group">
                <select class="control" v-for="(innerCategories, innerCatIndex) in sub_selections[i].categories" v-model="sub_selections[i].categories[innerCatIndex]">
                    <option v-for="(category, catIndex) in categories" :key="catIndex" v-bind:value="category.id">
                        {{ category.slug }}
                    </option>
                </select>

                <select class="control" v-for="(innerAttributeFamilies, innerFamIndex) in sub_selections[i].attribute_families" v-model="sub_selections[i].attribute_families[innerFamIndex]">
                    <option v-for="(attributeFamily, famIndex) in attribute_families" :key="famIndex" v-bind:value="attributeFamily.id">
                        {{ attributeFamily.name }}
                    </option>
                </select>
            </div>

            <div v-if="require_type_of_selection">
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

            <div style="margin-left: 20px;">
                <condition-wrapper :attributeFams='attributeFams' :cats='cats' v-for="(combine, combIndex) in sub_selections[i].combine" :key="combIndex"></condition-wrapper>
            </div>
            <button class="btn btn-primary btn-sm mb-10" v-on:click="insertCondition(i)" v-if="toggleAdd">+</button>
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
                handleCalled: 0,

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
                category: null,
                attribute_family: null,
                sub_selections: [],
                require_type_of_selection: false,
                toggleAdd: true
            };
        },

        mounted () {
            this.sub_selections.push(this.basic);

            this.categories = JSON.parse(this.cats);

            this.attribute_families = JSON.parse(this.attributeFams);
        },

        methods: {
            insertCondition (index) {
                event.preventDefault();

                this.toggleAdd = false;

                this.require_type_of_selection = true;
            },

            handleTypeSelection(index) {
                this.toggleAdd = true;

                // this.sub_selections[index].hide_type_selection = true;

                if (this.sub_selections[index].type_selection == 'category') {
                    this.sub_selections[index].categories.push(this.category);

                    // this.sub_selections[index].hide_category = false;
                } else if (this.sub_selections[index].type_selection == 'attribute_family') {
                    this.sub_selections[index].attribute_families.push(this.attribute_family);

                    // this.sub_selections[index].hide_attribute_family = false;
                } else {
                    this.$self
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

            removeConditionObject(index) {
                removedObject = this.allconditions.splice(index, 1);

                console.log(removedObject);
            }
        }
    }
</script>
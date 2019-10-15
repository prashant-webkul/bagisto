<div class="control-group" v-if="! sub_selections[i].hide_type_selection">
    <select class="control" v-model="sub_selections[i].type_selection" v-on:change="handleTypeSelection(i)">
        <option value="combine">Combine Conditions</option>
        <optgroup label="Select Option">
            <option value="attribute_family">Attribute Family</option>
            <option value="category">Category</option>
        </optgroup>
    </select>
</div>

<span v-if="sub_selections[i].hide_type_selection"><b>@{{ sub_selections[i].type_selection }}</b> is</span>
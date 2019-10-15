<div class="control-group" v-if="! sub_selections[i].hide_attribute_family">
    <select class="control" v-model="sub_selections[i].family" v-on:change="handleAttributeFamilyChange(i)">
        <option v-for="(attributeFamily, famIndex) in attributeFamilies" :key="famIndex" v-bind:value="attributeFamily.id">
            @{{ attributeFamily.name }}
        </option>
    </select>
</div>

<span v-if="sub_selections[i].hide_attribute_family">
    <b v-for="attributeFamily in attributeFamilies" v-if="attributeFamily.id == sub_selections[i].family">@{{ attributeFamily.name }}</b>
</span>
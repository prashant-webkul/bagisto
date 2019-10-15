<div class="control-group" v-if="! sub_selections[i].hide_category">
    <select class="control" v-model="sub_selections[i].category" v-on:change="handleCategoryChange(i)">
        <option v-for="(category, catIndex) in categories" :key="catIndex" v-bind:value="category.id">
            @{{ category.slug }}
        </option>
    </select>
</div>

<span v-if="sub_selections[i].hide_category">
    <b v-for="category in categories" v-if="category.id == sub_selections[i].category">@{{ category.name }}</b>
</span>
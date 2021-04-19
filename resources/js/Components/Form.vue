<template>

    <div class="mb-4">
        <breeze-label for="title" value="Title"/>
        <breeze-input class="w-full mt-2" id="title" type="text" v-model="form.title" required></breeze-input>
    </div>

    <div class="mb-4">
        <breeze-label for="category_id" value="Type"/>
        <breeze-select-option class="mt-2" id="category_id" v-model:category_id="form.category_id" :categories="categories" :form="form"></breeze-select-option>
    </div>

    <div class="mb-4">
        <breeze-label for="description" value="Description"/>
        <breeze-text-area class="w-full mt-2" id="description" type="text" v-model="form.description"></breeze-text-area>
    </div>
    <div class="flex items-center justify-between mt-4">
        <breeze-button> Submit</breeze-button>
        <inertia-link :href="route('entries.index')" class="btn btn-link">Cancel</inertia-link>
    </div>
</template>

<script>

import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import BreezeInput from '@/Components/Input'
import BreezeLabel from '@/Components/Label'
import BreezeValidationErrors from '@/Components/ValidationErrors'
import BreezeTextArea from '@/Components/TextArea'
import BreezeButton from '@/Components/Button'
import BreezeSelectOption from '@/Components/SelectOption'

export default {
    name: "Form.vue",
    components : {
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        BreezeTextArea,
        BreezeButton,
        BreezeSelectOption
    },
    props : {
        form : Object,
        categories : Array
    }
}
</script>

<style scoped>

</style>

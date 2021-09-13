<template>
    <breeze-authenticated-layout>
        <div class="container mx-auto">
            <div class="">
                <div class="w-2/3 mx-auto">
                    <breeze-validation-errors class="mb-4" />
                    <div class="card">
                        <h4 class="text-center pt-4">Edit Entry</h4>
                        <form class="form-group px-4" @submit.prevent="editLog">
                            <breeze-form :form="form" :categories="categories"></breeze-form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import BreezeForm from '@/Components/Form'
import BreezeValidationErrors from '@/Components/ValidationErrors'
export default {
    name: "Edit",
    props : ['entry', 'categories'],
    components : { BreezeAuthenticatedLayout, BreezeForm, BreezeValidationErrors},
    data() {
        return {
            form: {
                title: this.entry.title,
                description: this.entry.description,
                category_id: this.entry.category_id,
            },
            errors : ""
        }
    },
    methods: {
        editLog(){
            this.$inertia.patch(route('entries.update', this.entry), this.form)
                .then(() => {
                    this.form = {};
                    window.location.href = route('entries.index')
                }).catch(error => {
                this.errors = error.response.data.errors
            })
        }
    },
}
</script>

<style scoped>

</style>

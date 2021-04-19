<template>
    <breeze-authenticated-layout>
        <div class="container mx-auto">
            <div class="">
                <div class="w-2/3 mx-auto">
                    <breeze-validation-errors class="mb-4" />
                    <div class="card">
                        <h4 class="text-center pt-4">Add an Entry</h4>
                        <form class="form-group px-4" @submit.prevent="addLog">
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
    name: "Create",
    components : {BreezeAuthenticatedLayout, BreezeForm, BreezeValidationErrors},
    props: ["categories"],
    data() {
        return {
            form: {
                description: "",
                title: "",
                category_id: "",
            },
            errors: "",
        };
    },
    methods: {
        addLog() {
            this.$inertia.post(route("entries.store"), this.form)
                .then(()=> {
                    this.form = {}
                })
                .catch(error=>  this.errors = error.response.data.errors);
        },
    },
};
</script>

<style scoped>
</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="text-center pt-4">Add an Entry</h4>
                    <form class="form-group px-4" @submit.prevent="addLog">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input
                                type="text"
                                class="form-control"
                                name="title"
                                v-model="form.title"
                                id="title"
                            />
                            <span v-if="errors" class="text-danger">{{
                                errors.title[0]
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Type:</label>
                            <select
                                name="category_id"
                                id="category_id"
                                class="form-control"
                                v-model="form.category_id"
                            >
                                <option selected disabled value="">
                                    Choose your category
                                </option>
                                <option
                                    v-for="(category, index) in categories"
                                    :key="index"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                            <span v-if="errors" class="text-danger">{{
                                errors.category_id[0]
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea
                                type="text"
                                class="form-control"
                                name="description"
                                id="description"
                                v-model="form.description"
                            ></textarea>
                            <span v-if="errors" class="text-danger">{{
                                errors.description[0]
                            }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a
                                :href="route('entries.index')"
                                class="btn btn-link"
                                >Cancel</a
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Create",
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
            axios
                .post(route("entries.store"), this.form)
                .then(()=> {
                    this.form = {}
                    window.location.href = route('entries.index')
                })
                .catch(error=>  this.errors = error.response.data.errors);
        },
    },
};
</script>

<style scoped>
</style>

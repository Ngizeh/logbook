<template>
    <div>
        <p v-show="loading">Loading...</p>
        <table class="w-full bg-white items-left">
            <thead class="border-2">
                <tr class="text-left">
                    <th class="py-4 pl-3">Date</th>
                    <th class="py-4">Category</th>
                    <th class="py-4">Title</th>
                    <th class="py-4">Description</th>
                    <th class="py-4">Action</th>
                </tr>
            </thead>
            <tbody v-if="data.length > 0">
                <tr v-for="entry in data" :key="entry.id" class="border-2">
                    <td class="py-4 pl-3">{{ entry.formattedDate }}</td>
                    <td class="py-4">{{ entry.category.name }}</td>
                    <td class="py-4">{{ entry.title }}</td>
                    <td class="py-4">{{ entry.shortDescription }}</td>
                    <td class="py-4">
                        <div class="dropdown">
                            <span
                                role="button"
                                id="dropdownMenuLink"
                                :data-toggle="toggle"
                                aria-haspopup="false"
                                aria-expanded="false"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-three-dots-vertical"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                                    />
                                </svg>
                            </span>
                            <div
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuLink"
                            >
                                <a
                                    class="dropdown-item"
                                    :href="route('entries.show', entry)"
                                    >View</a
                                >
                                <a
                                    class="dropdown-item"
                                    :href="route('entries.edit', entry)"
                                    >Edit</a
                                >
                                <form @submit.prevent="deleteEntry(entry)">
                                    <button type="submit" class="dropdown-item">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center">
                        <span>
                            No entry found
                            <inertia-link :href="route('entries.create')">Add an entry</inertia-link>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "EntriesTable",
    props: ["entries", "entry"],
    data() {
        return {
            error: null,
            data: this.entries,
            dropdown: "dropdown",
            loading: false,
        };
    },
    methods: {
        deleteEntry(entry) {
            axios
                .delete(route("entries.destroy", entry))
                .then(() => {
                    this.data.splice(this.data.indexOf(entry), 1);
                    this.dropdown = "";
                })
                .catch((error) => error.response.data.errors);
        },
        loadData(url, func){
            emitter.on(func, (date) => {
                axios.get(route(url, date))
                    .then((response) => {
                        this.loading = true;
                        this.data = response.data[0];
                        this.loading = false;
                    })
                    .catch((error) => error.response.data.errors);
            })
        }
    },
    computed: {
        toggle() {
            return (this.dropdown = "dropdown");
        },
    },
    mounted() {
        this.loadData("entries.weekending", "weekEntry");
        this.loadData("entries.dayEnding", "dayEntry");
    },
};
</script>

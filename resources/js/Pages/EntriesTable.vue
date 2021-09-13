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
                        <breeze-dropdown align="left" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <breeze-dropdown-link :href="route('entries.show', entry)">View</breeze-dropdown-link>
                                <breeze-dropdown-link :href="route('entries.edit', entry)">Edit</breeze-dropdown-link>
                                <form @submit.prevent="deleteEntry(entry)">
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Delete</button>
                                </form>
                            </template>
                        </breeze-dropdown>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center py-4">
                        <span>
                            No entry found
                            <inertia-link :href="route('entries.create')" class="text-blue-500 hover:text-blue-400">Add an entry</inertia-link>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import BreezeDropdown from "@/Components/Dropdown";
import BreezeDropdownLink from "@/Components/DropdownLink";
export default {
    name: "EntriesTable",
    components: { BreezeDropdown, BreezeDropdownLink },
    props: ["entries", "entry"],
    data() {
        return {
            error: null,
            data: this.entries,
            loading: false,
        };
    },
    methods: {
        deleteEntry(entry) {
            axios
                .delete(route("entries.destroy", entry))
                .then(() => {
                    this.data.splice(this.data.indexOf(entry), 1);
                })
                .catch((error) => error.response.data.errors);
        },
        loadData(url, func) {
            emitter.on(func, (date) => {
                axios
                    .get(route(url, date))
                    .then((response) => {
                        this.loading = true;
                        this.data = response.data[0];
                        this.loading = false;
                    })
                    .catch((error) => error.response.data.errors);
            });
        },
    },
    mounted() {
        this.loadData("entries.weekending", "weekEntry");
        this.loadData("entries.dayEnding", "dayEntry");
    },
};
</script>

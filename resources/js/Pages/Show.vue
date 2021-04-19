<template>
    <breeze-authentication-layout>
        <div class="w-2/5 mx-auto mt-6">
            <div class="flex justify-between py-4 px-3 bg-gray-200 rounded-t">
                <div class="flex">
                    <h2>{{ entry.title }}</h2>
                    <p class="pl-2">{{ entry.formattedDate }} </p>
                </div>
            <p class="pl-4">{{ entry.category.name }} </p>
            </div>
            <div class="py-4 bg-white">
                <p class="pl-2">{{ entry.description }} </p>
            </div>
            <div class="py-4 bg-gray-200 flex justify-between px-4">
            <inertia-link :href="route('entries.edit', entry)" class="text-blue-500 hover:text-blue-400">Edit Entry</inertia-link>
            <inertia-link :href="route('entries.index')">Back</inertia-link>
            </div>
        </div>
    </breeze-authentication-layout>
</template>

<script>
import BreezeAuthenticationLayout from '@/Layouts/Authenticated'
export default {
    name: "Show",
    components: { BreezeAuthenticationLayout},
    props : ['entry']
}
</script>

<style scoped>

</style>

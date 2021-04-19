<template>
    <textarea cols="30" rows="5"
     class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="textarea">

    ></textarea>
</template>

<script>
export default {
    name: "TextArea",
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.textarea.focus()
            }
        }
}
</script>

<style scoped>

</style>

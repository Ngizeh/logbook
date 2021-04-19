<template>
    <div class="form-group">
        <select
            name="category_id"
            id="category_id"
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            @input="$emit('update:category_id', $event.target.value)"
            ref="select"
        >
            <option selected disabled :value="null"> 
                Choose your category
            </option>
            <option
                v-for="(category, index) in categories"
                :key="index"
                :value="category.id"
                :selected="selectedOption(category.id)"
            >
                {{ category.name }}
            </option>
        </select>
    </div>
</template>

<script>
 export default {
     name : 'SelectOption',
     props : ['categories', 'category_id','form'],
     emits : ['update:category_id'],

     methods: {
         focus() {
             this.$refs.select.focus()
         },
         selectedOption(option){
            return option === this.form.category_id ? option : false ;
         }
     }
    }
</script>

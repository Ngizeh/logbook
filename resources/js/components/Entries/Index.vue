<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="" id="" class="form-control" @change="weeklyEntry($event)">
                                    <option v-for="(date, index) in dates" :key="index" :value="date">Week Ending {{ date }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="/entries/create" class="btn btn-success">Add</a>
                            </div>
                        </div>
                    </div>
                    <entries-table :entries="entries" @weekEntry="entry"></entries-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EntriesTable from "./EntriesTable";
    export default {
        components: {EntriesTable},
        props : ['entries', 'dates'],
        methods : {
        	weeklyEntry(e){
				this.entry(e.target.value)
			},
			entry(date){
				this.$root.$emit('weekEntry', date)
			}
        },
    }
</script>

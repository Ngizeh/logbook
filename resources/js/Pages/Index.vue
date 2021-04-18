<template>
    <div class="container mx-auto pt-10">
            <div class="">
                <div class="w-2/3 text-right mx-auto mb-4">
                    <inertia-link :href="route('entries.create')" class="bg-green-500 py-3 px-3 rounded text-gray-200 hover:bg-green-400 hover:text-white">Add</inertia-link>
                </div>
                <div class="w-2/3 mx-auto text-small">
                        <div class="flex justify-between py-5 px-3 bg-gray-100 rounded">
                            <select class="rounded w-2/4 week" @change="weeklyEntry($event)">
                                <option v-for="(date, index) in entriesDate" :key="index" :value="date">Week Ending {{ date }}</option>
                            </select>

                            <select class="rounded w-1/4 selector" @change="dailyEntry($event)">
                                <option selected value="full_week">Full Week Entry</option>
                                <option :value="day.val" v-for="(day, index) in days" :key="index">{{ day.d }}</option>
                            </select>
                        </div>
                    <entries-table :entries="weeklyEntries"></entries-table>
                </div>
            </div>
    </div>
</template>

<script>
import EntriesTable from "./EntriesTable";
import moment from 'moment';
import emit from "mitt";
export default {
    components: {EntriesTable},
    props : ['weeklyEntries', 'entriesDate'],
    data(){
        return {
            days : [
                {"val" : -6, "d" : "Monday"},
                {"val" : -5, "d" : "Tuesday"},
                {"val" : -4, "d" : "Wednesday"},
                {"val" : -3, "d" : "Thursday"},
                {"val" : -2, "d" : "Friday"},
                {"val" : -1, "d" : "Saturday"},
                {"val" : 0, "d" : "Sunday"},
            ],
            weekday : ''
        }
    },
    methods : {
        weeklyEntry(e){
            document.getElementsByClassName('selector')[0].selectedIndex = 0
            this.weekday = e.target.value;
            this.week(this.weekday)
        },
        dailyEntry(e){
            this.day(e.target.value)
        },
        week(date){
            emitter.emit('weekEntry', date)
        },
        day(date){
            let defaultDate = document.getElementsByClassName('week')[0].value;
            let weekDate = this.weekday || defaultDate ;
            let daySelected = moment(weekDate, "MMMM D, YYYY").weekday(date).format('MMMM D, YYYY');
            emitter.emit('dayEntry', daySelected)
        }
    },
}
</script>

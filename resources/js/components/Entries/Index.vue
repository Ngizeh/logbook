<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-right mb-2">
                    <a href="/entries/create" class="btn btn-success">Add</a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control week" @change="weeklyEntry($event)">
                                    <option v-for="(date, index) in dates" :key="index" :value="date">Week Ending {{ date }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control selector" @change="dailyEntry($event)">
                                    <option selected value="full_week">Full Week Entry</option>
                                    <option :value="day.val" v-for="(day, index) in days" :key="index">{{ day.d }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <entries-table :entries="weeklyEntries"></entries-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EntriesTable from "./EntriesTable";
import moment from 'moment';
export default {
    components: {EntriesTable},
    props : ['weeklyEntries', 'dates'],
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
            this.$root.$emit('weekEntry', date)
        },
        day(date){
            let defaultDate = document.getElementsByClassName('week')[0].value;
            let weekDate = this.weekday || defaultDate ;
            let daySelected = moment(weekDate).weekday(date).format('MMMM D, YYYY');
            this.$root.$emit('dayEntry', daySelected)
        }
    },
}
</script>

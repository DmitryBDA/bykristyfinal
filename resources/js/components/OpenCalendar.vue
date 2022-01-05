<template>
    <div>
        <a @click="openCalendar" class="btn btn-primary btn-xl text-uppercase">Tell Me More</a>
    </div>
</template>

<script>
import EventBus from '../usercalendar.js'
export default {

    data() {
        return {

        }
    },
    methods: {
        openCalendar() {
            //As an ES6 module.
            EventBus.$emit("openCalendar");
        },
    }

}
</script>

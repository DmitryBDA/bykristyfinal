<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'


export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    data: function() {
        return {
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    interactionPlugin // needed for dateClick
                ],
                headerToolbar: {
                },
                timeZone: 'UTC',
                firstDay: 1,
                locale:'ru',
                themeSystem: 'bootstrap',
                eventDisplay: 'block',
                initialView: 'dayGridMonth',
                nextDayThreshold: '00:00:00',
                editable: true,
                selectable: true,
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                weekends: true,
                events:  this.showRecords,
                // eventClick: this.handleEventClick,
                // eventsSet: this.handleEvents,
                // dateClick: this.clickDate
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
        }
    },
    methods: {
        showRecords(){

        }
    }
}
</script>
<template>
    <div>
        <FullCalendar :options="calendarOptions" />
    </div>
</template>


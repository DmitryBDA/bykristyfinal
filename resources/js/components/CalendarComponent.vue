<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import ModalAddRecord from "./ModalAddRecord";

export default {
    components: {
        ModalAddRecord,
        FullCalendar,
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
                height: 700,
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
                eventClick: this.clickRecord,
                // eventsSet: this.handleEvents,
                dateClick: this.dateClick
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            date:null,
            dataRecord: [],
            messageTitleRecord:null,
        }
    },
    methods: {
        showRecords(){
            axios
                .get('/api/calendar/show-records').then((response)=>{
                this.calendarOptions.events = response.data
            })
        },
        dateClick(record){
            this.$refs.modal_add_record.date = record.dateStr
            this.$refs.modal_add_record.inputTime = [{
                    typeRecord:false,
                    value:'00:00',
                    status: 1,
                    title: ''
                }]
            this.$refs.modal_add_record.$refs._open_modal_add_record.click()

        },
        clickRecord(record) {
            this.recordId = record.event._def.publicId
            axios.post('/api/calendar/get-data-record', {recordId:this.recordId})
                .then((response)=>{
                    this.$refs.modal_action_record.dataRecord = response.data;
                    this.$refs.modal_action_record.$refs.open_modal_action_records.click()
                })
        },
    }
}
</script>
<template>
    <div>
        <FullCalendar :options="calendarOptions" />
        <modal-add-record ref="modal_add_record"></modal-add-record>
        <modal-action-record ref="modal_action_record"></modal-action-record>
    </div>
</template>
<style>
.timeline>div>.timeline-item{
    margin-left: 0!important;
    margin-right: 0!important;
}
.timeline>div>.timeline-item>.time{
    float: left;
}
.list-group-item{
    padding: 3px 8px;
}
.fc-event-title-container{
    display: none!important;
}
.fc-title {
    color: #fff;
}
.fc-title:hover {
    cursor: pointer;
}

.greenEvent {
    background-color:#1d8b1d;
}

.yellowEvent {
    background-color:#a7a739;
}

.redEvent {
    background-color:#bf0d0d;
}
.greyEvent {
    background-color:grey;
}

.hiddenevent{
    font-size: 9px;
}
.fc-daygrid-block-event .fc-event-time{
    font-weight: 400!important;
}
.fc-daygrid-day-top a{
    color: black;
}
.fc-event-time{
    color: white;
}
.fc-daygrid-event-dot{
    display: none;
}
</style>


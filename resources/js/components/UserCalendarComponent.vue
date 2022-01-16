<script>
import EventBus from '../usercalendar.js'
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'


import ModalRecordUser from "./ModalRecordUser";
export default {
    components: {
        ModalRecordUser,
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
                    left: 'title',
                    right: 'prev,next'
                },
                height: 600,
                timeZone: 'UTC',
                firstDay: 1,
                locale:'ru',
                themeSystem: 'bootstrap',
                eventDisplay: 'block',
                initialView: 'dayGridMonth',
                nextDayThreshold: '00:00:00',
                editable: false,
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
                //dateClick: this.dateClick
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            },
            date:null,
            dataRecord: [],
            clickOpenCalendar:false
        }
    },
    mounted() {
        //As an ES6 module
        EventBus.$on("openCalendar", () => {
            this.clickOpenCalendar = true
            this.showRecords();
        });
        EventBus.$on("updateCalendar", () => {
            this.showRecords();
        });
    },
    methods: {
        showRecords(){
            axios
                .get('/api/calendar/show-records-users')
                .then((response)=>{
                    if(this.clickOpenCalendar){
                        this.$refs.testt.click()
                    }
                    this.calendarOptions.events = response.data
            })
        },
        openModalRecordUser(data) {
            //As an ES6 module.
            EventBus.$emit("openModalRecordUser", data);
        },
        // dateClick(record){
        //     this.date = record.dateStr
        //     this.$refs.modal_add_record.inputTime = [{
        //             typeRecord:false,
        //             value:'00:00',
        //             status: 1,
        //             title: ''
        //         }]
        //     this.$refs.modal_add_record.$refs._open_modal_add_record.click()
        //
        // },
        clickRecord(record) {
            const recordId = record.event._def.publicId

             axios.post('/calendar/get-data-record-user', {recordId:recordId})
                 .then((response)=>{
                     this.dataRecord = response.data;
                     this.openModalRecordUser({
                         id: response.data.id,
                         time: response.data.time,
                         dayWeek: response.data.dayWeek,
                         date: response.data.date,
                         selectedService: localStorage.selectedService ? localStorage.selectedService : '',
                         name: localStorage.name ? localStorage.name : '',
                         surname: localStorage.surname ? localStorage.surname : '',
                         phone: localStorage.phone ? localStorage.phone : '',
                     })
                 })
        },
    }
}
</script>
<template>
    <div>
        <FullCalendar :options="calendarOptions" />
        <button style="display: none" data-toggle="modal" data-target="#modal-xl" ref="testt"></button>
<!--        <modal-action-record :dataRecord="dataRecord"></modal-action-record>-->
    </div>
</template>
<style>

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


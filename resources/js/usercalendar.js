

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('usercalendar-component', require('./components/UserCalendarComponent.vue').default);
Vue.component('opencalendar-component', require('./components/OpenCalendar.vue').default);
Vue.component('modal-record-user-component', require('./components/ModalRecordUser.vue').default);

const EventBus = new Vue();
export default EventBus;
const app = new Vue({
    el: '#app',
});

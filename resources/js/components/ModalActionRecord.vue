<template>
    <div>
        <div class="modal fade" id="modal-action-with-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Выбор действия</h4>
                        <button type="button" class="close" data-dismiss="modal" ref="close_modal_action_records"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="">
                        <form class="form-horizontal _form_action_record" :data-record-id="recordId">
                            <div class="card-body">
                                <p>Выбранный день: {{date}} {{ dayWeek }}</p>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Время</label>
                                    <div class="col-sm-9">
                                        <input type="time" class="form-control" v-model="time">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Услуга</label>
                                    <div class="col-sm-9">
                                        <select v-model="selectedService" class="form-control _input_form_for_record">
                                            <option v-for="item in services" :value="item.id">{{ item.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control input-lg add_name"
                                               v-model="name"
                                               autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-9">
                                        <input type="text" v-model="phone"
                                               class="form-control">

                                        <a v-if="phone" :href="'whatsapp://send?phone=+7' + phone"
                                           class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-whatsapp"
                                                                              aria-hidden="true"></i></span>
                                        </a>
                                        <a v-if="phone" :href="'tel:+7' + phone"
                                           class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-volume-control-phone"
                                                                              aria-hidden="true"></i></span>
                                        </a>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button class="btn btn-info">Записать</button>
                                <button class="btn btn-info">Подтвердить</button>
                                <button class="btn btn-info">Отменить</button>
                                <button class="btn btn-success float-center">Сохранить</button>
                                <button class="btn btn-danger float-right" >Удалить</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button style="display: none" data-toggle="modal" data-target="#modal-action-with-records"
                ref="open_modal_action_records"></button>
    </div>
</template>

<script>

export default {
    props:['dataRecord'],
    data: function() {
        return {
            recordId:null,
            time:null,
            days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            dayWeek: null,
            date: null,
            selectedService:1,
            services:null,
            name: null,
            phone: null
        }
    },
    watch: {
        dataRecord: function (val) {
            this.recordId = this.dataRecord.id
            this.time = new Date(this.dataRecord.start).toLocaleTimeString().slice(0,-3)
            this.dayWeek = this.days[new Date(this.dataRecord.start).getDay()]
            this.date = new Date(this.dataRecord.start).toLocaleDateString()
            this.services = this.dataRecord.services
            this.selectedService = this.dataRecord.service_id ? this.dataRecord.service_id : 1
            this.name = this.dataRecord.user ? this.dataRecord.user.surname + ' ' + this.dataRecord.user.name : ''
            this.phone = this.dataRecord.user ? this.dataRecord.user.phone : ''

            this.$refs.open_modal_action_records.click()
        },
    },
    mounted() {

    },
    methods: {


    },
    validations: {

    }
}

</script>

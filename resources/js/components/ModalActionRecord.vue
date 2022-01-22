<template>
    <div>
        <div class="modal fade" id="modal-action-with-records" ref="modal_action_record">
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

                                <div v-if="statusRecord !== 4" class="form-group row">
                                    <label class="col-sm-3 col-form-label">Услуга</label>
                                    <div class="col-sm-9">
                                        <select v-model="selectedService" class="form-control _input_form_for_record">
                                            <option v-for="item in services" :value="item.id">{{ item.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="statusRecord !== 4" class="form-group row">
                                    <label class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control input-lg add_name"
                                               @keyup="getDataAutocomplete()"
                                               v-model="name"
                                               autocomplete="off">
                                        <div v-if="isActiveSearch" class="panel-footer"
                                             style="position: absolute;z-index: 1;">
                                            <ul class="list-group">
                                                <a href="#" @click.prevent="pasteName(name, phone)" class="list-group-item"
                                                   v-for="(name, phone) in search_data">{{ name }}</a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="statusRecord !== 4" class="form-group row">
                                    <label class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-9">
                                        <input v-mask="'##########'" type="text" v-model="phone"
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

                                <div v-if="statusRecord === 4" class="form-group row">
                                    <label class="col-sm-3 col-form-label">Название</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control input-lg add_name"
                                               v-model="title">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button v-if="statusRecord === 1" @click.prevent="recordUser()" class="btn btn-info">Записать</button>
                                <button v-if="statusRecord === 2"  @click.prevent="confirmRecord()" class="btn btn-info">Подтвердить</button>
                                <button v-if="statusRecord !== 1 && statusRecord !== 4" @click.prevent="cancelRecord()" class="btn btn-info">Отменить</button>
                                <button v-if="statusRecord !== 1 && isEdit" @click.prevent="saveDataRecord()" class="btn btn-success float-center">Сохранить</button>
                                <button class="btn btn-danger float-right" @click.prevent="deleteRecord()" >Удалить</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <button style="display: none" data-toggle="modal" data-target="#modal-action-with-records" ref="open_modal_action_records"></button>
        <button style="display: none" type="button" class="btn btn-success swalDefaultSuccess" @click.prevent="successSave" ref="mess_about_success_save">Сохранено</button>
    </div>
</template>

<script>
import TheMask from 'vue-the-mask'
export default {
    components: {
        TheMask
    },
    data: function() {
        return {
            recordId:null,
            time:null,
            dayWeek: null,
            date: null,
            selectedService:1,
            services:null,
            name: null,
            title: '',
            phone: null,
            statusRecord: null,
            isEdit: true,
            isActiveSearch:false,
            search_data: [],
            Toast:null,
            dataRecord:[]
        }
    },
    watch: {
        dataRecord: function (val) {
            this.recordId = this.dataRecord.id
            this.time = this.dataRecord.time
            this.dayWeek = this.dataRecord.dayWeek
            this.date = this.dataRecord.date
            this.selectedService = this.dataRecord.selectedService
            this.name = this.dataRecord.name
            this.title = this.dataRecord.title
            this.phone = this.dataRecord.phone
            this.statusRecord = this.dataRecord.statusRecord
            //this.$refs.open_modal_action_records.click()
        },
    },
    mounted() {
        this.Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        axios.get('/admin/service')
            .then((response)=>{
                this.services = response.data;
            })
    },
    methods: {
        recordUser() {
            axios.put('/admin/records/' + this.recordId, {
                    serviceId: this.selectedService,
                    name: this.name,
                    time: this.time,
                    phone: this.phone,
                    title: this.title
                }
            )
                .then((response) => {
                    this.$parent.showRecords()
                    this.$refs.close_modal_action_records.click();
                })

        },
        saveDataRecord(){
            axios.put('/admin/records/' + this.recordId, {
                    serviceId: this.selectedService,
                    name: this.name,
                    time: this.time,
                    phone: this.phone,
                    title: this.title
                }
            )
                .then((response) => {
                    this.$parent.showRecords()
                    this.$refs.mess_about_success_save.click();

                })
        },
        confirmRecord(){
            axios.put('/admin/records/confirm/' + this.recordId)
                .then((response) => {
                    this.$parent.showRecords()
                    this.$refs.close_modal_action_records.click();
                })
        },
        cancelRecord(){
            axios.put('/admin/records/cancel/' + this.recordId)
                .then((response) => {
                    if(response.data){
                        this.$parent.showRecords()
                        this.$refs.close_modal_action_records.click();
                    }
                })
        },
        deleteRecord(){
            axios.delete('/admin/records/'+ this.recordId)
                .then((response) => {
                    this.$parent.showRecords()
                    this.$refs.close_modal_action_records.click();
                })
        },
        getDataAutocomplete() {
            this.search_data = []

            if (this.name != '') {
                if(this.name.match(/([A-Za-zа-яА-ЯеЁ]+)/g).length == 1){
                    axios.get('/admin/search/input-name-autocomplete', { params: {str: this.name} })
                        .then((response) => {
                            this.search_data = response.data
                            this.isActiveSearch = true
                        })
                }
            }

        },
        successSave(){
            this.Toast.fire({
                icon: 'success',
                title: 'Сохранено'
            })
        },
        pasteName(name, phone) {
            this.name = name
            this.phone = phone
            this.isActiveSearch = false
        },

    }
}

</script>

<template>
  <div>
    <div class="modal fade" id="modal-record-records" ref="open_modal_record_user">
      <div class="modal-dialog">
        <div class="modal-content" style="background-color: #e2e2e2">
          <div class="modal-header">
            <h4 class="modal-title">Форма записи</h4>
          </div>
          <div class="">
            <form @submit.prevent="submit" class="form-horizontal _form_action_record"
                  :data-record-id="recordId">
              <div class="card-body">
                <p>Выбранный день: {{ date }} {{ dayWeek }}</p>
                <div class="form-group row mb-2">
                  <label class="col-sm-3 label col-form-label">Время</label>
                  <div class="col-sm-9 value">
                    <input disabled type="time" class="form-control" v-model="time">
                  </div>


                </div>
                <template v-if="isSuccessRecord === false">
                  <div class="form-group row mb-2">
                    <label class="col-sm-3 label col-form-label">Услуга</label>
                    <div class="col-sm-9 value">
                      <select :required="true" v-model="selectedService"
                              class="form-control _input_form_for_record">
                        <option v-for="item in services" :value="item.id">{{
                            item.name
                          }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row mb-2">
                    <label class="col-sm-3 label col-form-label">Имя</label>
                    <div class="col-sm-9 value">
                      <input required type="text"
                             class="form-control input-lg add_name"
                             autocomplete="off"
                             v-model="name">

                    </div>
                  </div>
                  <div class="form-group row mb-2">
                    <label class="col-sm-3 label col-form-label">Фамилия</label>
                    <div class="col-sm-9 value">
                      <input required type="text"
                             class="form-control input-lg add_name"
                             autocomplete="off"
                             v-model="surname">

                    </div>
                  </div>
                  <div class="form-group row mb-2">
                    <label class="col-sm-3 label col-form-label">Телефон</label>
                    <div class="col-sm-9 value">
                      <input type="tel" v-mask="'+7 (###) ###-##-##'" required v-model="phone"
                             autocomplete="off"
                             placeholder="(999) 999-99-99"
                             class="form-control input-lg add_name">
                    </div>
                  </div>

                  <div class="form-group row mb-2">
                    <label class="col-sm-3 label col-form-label">Комент</label>
                    <div class="col-sm-9 value">
                      <textarea v-model="comment" class="form-control" rows="3" placeholder="Введите текст сообщения"></textarea>
                    </div>
                  </div>

                </template>
                <div class="text-success" v-else>
                  <p>Вы успешно записаны</p>
                </div>
                <p v-if="isRecordBusy" class="small text-danger">Данное время уже занято <br> обновите календарь</p>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button v-if="isSuccessRecord === false" class="btn btn-info">Записать</button>
                <button type="button" class="btn btn-default right" ref="close_modal_record_user"
                        data-dismiss="modal">Закрыть
                </button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
        </div>
      </div>
    </div>
    <button style="display: none" data-toggle="modal" data-target="#modal-record-records"
            ref="open_modal_record_user"></button>
  </div>
</template>

<script>

import EventBus from "../usercalendar";
import TheMask from 'vue-the-mask'

export default {
  components: {
    TheMask
  },
  data: function () {
    return {
      recordId: null,
      time: null,
      days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
      dayWeek: null,
      date: null,
      selectedService: '',
      services: null,
      name: '',
      surname: '',
      phone: null,
      statusRecord: null,
      isEdit: true,
      isActiveSearch: false,
      search_data: [],
      Toast: null,
      isRecordBusy: false,
      isSuccessRecord: false,
      comment:''
    }
  },
  watch: {
    phone: function (val) {
      if (val === '+7 (8') {
        this.phone = '+7 ('
      }
    }
  },
  mounted() {
    EventBus.$on("openModalRecordUser", (data) => {
      // data.services.unshift({
      //     name:'Не выбрано',
      //     id:0
      // })
      this.recordId = data.id
      this.time = data.time
      this.dayWeek = data.dayWeek
      this.date = data.date
      this.selectedService = data.selectedService
      this.name = data.name
      this.surname = data.surname
      this.phone = data.phone
      this.isRecordBusy = false
      this.$refs.open_modal_record_user.click()
      this.isSuccessRecord = false
    });
    axios.get('/service')
      .then((response) => {
        this.services = response.data;
      })
  },
  methods: {
    recordUser() {

    },
    submit() {
      axios.post('/records/' + this.recordId, {
          serviceId: this.selectedService,
          name: this.surname + ' ' + this.name,
          phone: this.phone,
          comment:this.comment
        }
      )
        .then((response) => {
          if (response.data == 'busy') {
            localStorage.name = this.name;
            localStorage.surname = this.surname;
            localStorage.phone = this.phone;
            localStorage.selectedService = this.selectedService;
            this.isRecordBusy = true
          } else {
            localStorage.name = '';
            localStorage.surname = '';
            localStorage.phone = '';
            localStorage.selectedService = '';
            console.log(response.data)
            this.updateCalendar()
            this.isSuccessRecord = true
            //this.$refs.close_modal_record_user.click()
          }

        })
    },
    updateCalendar() {
      //As an ES6 module.
      EventBus.$emit("updateCalendar");
    },
  },
  validations: {}
}

</script>

<template>

    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">

                    <div class="card collapsed-card">

                        <div class="card-header">
                            <h3 class="card-title _title_active_list">Активные записи</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-plus" @click="listUp"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: none; padding: 0 0 0 5px">
                            <input v-model="search" class="form-control filter mb-2" type="text"
                                   placeholder="Ведите для поиска">
                            <div class="timeline">
                                <template v-for="(item, idx) in listRecords">
                                    <div class="time-label">
                                        <span class="bg-green">{{ item.date }}</span>
                                    </div>
                                    <div>
                                        <template v-for="elem in item.value">
                                            <div class="timeline-item" style="position: relative">
                                                <span class="time"><i class="fas fa-clock"></i> {{ elem.time }}</span>
                                                <h3 class="timeline-header">{{ elem.name }}
                                                    <a style="position: absolute; width: 40px; right: 44px  ; top: 3px;"
                                                       :href="'whatsapp://send?phone=+7' + elem.phone"
                                                       class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-whatsapp"
                                                                              aria-hidden="true"></i></span>
                                                    </a>
                                                    <a style="position: absolute; width: 40px; right: 0px; top: 3px;"
                                                       :href="'tel:+7' + elem.phone"
                                                       class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-volume-control-phone"
                                                                              aria-hidden="true"></i></span>
                                                    </a>
                                                </h3>

                                            </div>
                                        </template>
                                    </div>
                                </template>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
export default {
    data() {
        return {
            listRecords: [],
            search: ''
        }
    },
    watch: {
        search: function (val) {
            if (val.match(/([A-Za-zа-яА-ЯеЁ]+)/g)) {
              this.getListActiveRecords(val)
            }
        },
    },
    mounted() {
       this.getListActiveRecords('')
    },
    methods: {
        listUp() {
            $('html, body').animate({
                scrollTop: $("._title_active_list").offset().top  // класс объекта к которому приезжаем
            }, 500); // Скорость прокрутки
        },
        getListActiveRecords(val){

          axios.get('/admin/search/get-list-active-records', { params: {strSearch: val} })
            .then((response) => {
              this.listRecords = response.data
            })
        }
    }

}
</script>

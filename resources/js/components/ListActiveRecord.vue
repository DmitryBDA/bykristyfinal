<template>
    <div>
        <section class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-12">
                        <div class="timeline">
                            <template v-for="(item, idx) in listRecords">
                                <div class="time-label">
                                    <span class="bg-green">{{ item.date }}</span>
                                </div>
                                <div>
                                    <div class="timeline-item">
                                        <template v-for="elem in item.value">
                                            <span class="time"><i class="fas fa-clock"></i> {{ elem.time }}</span>
                                            <h3 class="timeline-header">{{ elem.name }}
                                                <a style="position: absolute; width: 40px; right: 44px  ; top: 3px;" href="whatsapp://send?phone=+7543453453"
                                                   class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-whatsapp"
                                                                              aria-hidden="true"></i></span>
                                                </a>
                                                <a style="position: absolute; width: 40px; right: 0px; top: 3px;" href="tel:+75454645"
                                                   class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-volume-control-phone"
                                                                              aria-hidden="true"></i></span>
                                                </a>
                                            </h3>
                                        </template>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            listRecords: [{
                'date': '12.12.2021',
                'value': {
                    'list1': {
                        'time': '12:00',
                        'name': 'Ирина Алексеева'
                    },
                    'list2': {
                        'time': '15:00',
                        'name': 'Белоусов Дмитрий'
                    },

                }
            }]
        }
    },
    mounted() {

    },
    methods: {

    }

}
</script>

<template>
    <div>
        <div class="modal fade" id="modal-add-records">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавить запись</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form class="_form_add-records" :data-date="date" >
                        <div class="card-body">
                            <div class="form-group _time_records">
                                <label>Время</label>
                            </div>
                            <p>Добавьте новую запись</p>
                            <template>
                                <div class="input-group mb-3 _time_record">
                                    <input type="time" name="time" class="form-control" value="12:00">
                                    <input type="text" name="title" value="10:00" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-times"></i></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="card-footer">
                            <button  type="button" class="btn btn-primary ml-0">Добавить</button>
                            <button  type="button" class="btn btn-primary ml-0 ">Личное</button>
                            <button  type="submit" class="btn btn-primary mr-0 ">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button style="display: none" data-toggle="modal" data-target="#modal-add-records" ref="_open_modal_add_record" ></button>
    </div>
</template>

<script>
export default {
    props:['date'],
    watch: {

    },
    data() {
        return {

        }
    },
    methods: {

    }

}
</script>

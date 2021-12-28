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
                        <form class="form-horizontal _form_action_record" data-record-id="12">
                            <div class="card-body">
                                <p>Выбранный день: 22.12.2021 (четверг)</p>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Время</label>
                                    <div class="col-sm-9">
                                        <input type="time" class="form-control" name="time">
                                    </div>


                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Услуга</label>
                                    <div class="col-sm-9">
                                        <select class="form-control _input_form_for_record">
                                            <option value="1">fsdf</option>
                                            <option value="2">fsdf</option>
                                            <option value="3">fsdfsd</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control input-lg add_name"
                                               name="name"
                                               autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="input-group mb-3 col-sm-9">
                                        <input type="text" name="phone"
                                               class="form-control">

                                        <a href="whatsapp://send?phone=+79149098288"
                                           class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                                        </a>
                                        <a href="tel:+79149098288"
                                           class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
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
        <button style="" data-toggle="modal" data-target="#modal-action-with-records"
                ref="open_modal_action_records"></button>
    </div>
</template>

<script>

export default {
    props:['dataRecord'],
    mounted() {

    },
    methods: {


    },
    validations: {

    }
}

</script>

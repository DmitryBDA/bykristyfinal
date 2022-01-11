<?php

namespace App\Presenters\User;

use App\Presenters\Presenter;

class UserPresenter extends Presenter
{
    public function fullName()
    {
        return trim($this->model->surname . ' ' . $this->model->name);
    }
}

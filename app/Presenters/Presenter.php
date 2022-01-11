<?php

namespace App\Presenters;

abstract class Presenter
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }
}

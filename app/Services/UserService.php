<?php

namespace App\Services;

class UserService
{
    public function arrPhoneName($obUsers){
        $arResult = [];
        foreach ($obUsers as $obUser) {
            $arResult[$obUser->phone] = $obUser->surname . ' ' . $obUser->name;
        }
        return $arResult;
    }
}

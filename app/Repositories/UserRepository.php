<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\User as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return mixed
     */

    public function getUser($data){
        //Поиск пользователя по телефону
        $phone = str_replace(['+7', '(', ')', ' ', '-'],'',$data['phone']);
        $user = $this->findUserByPhone($phone);

        //Если пользователь не найден
        if (!$user) {
            //Создать нового пользователя
            $user = $this->createUser($data);
        }
        return $user;
    }

    public function searchAutocomplete($query){
        $users = $this->startCondition()
            ->where('name', 'LIKE', '%'.$query.'%')
            ->orWhere('surname', 'LIKE', '%'.$query.'%')
            ->get();

        $name = [];
        if($users){
            foreach ($users as $user) {
                $name[$user->phone] = $user->surname . ' ' . $user->name;
            }
        }
        return $name;
    }

    private function createUser($data){

        $arFio = explode(" ", $data['name']);
        $surname = $arFio[0] ? $arFio[0] : "" ;
        $name = $arFio[1] ? $arFio[1] : "" ;

        $lastId = User::orderBy('id', 'desc')->get()->first()->id;
        $lastId++;
        $dataUser = [
            'name' => $name,
            'surname' => $surname,
            'phone' => str_replace(['+7', '(', ')', ' ', '-'],'',$data['phone']),
            'password' => Hash::make(Str::random(8)),
            'email' => "user$lastId@user.com",
        ];

        $user = $this->startCondition()->create($dataUser);
        return $user;
    }



    private function findUserByPhone($phone){
        $user = $this->startCondition()
            ->select('id', 'name', 'surname', 'phone')
            ->where('phone', $phone)
            ->first();

        return $user;
    }

}

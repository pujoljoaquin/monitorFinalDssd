<?php

namespace Monitor;


class Users{

    public static function getUsers(){
        $response = Request::doTheRequest('GET', 'API/identity/user?p=0&c=1000&o=lastname%20ASC');
        return  $response['data'];
    }

    public static function getUserUsername($id){
        $response = Request::doTheRequest('GET', 'API/identity/user/'.$id);
        $user = $response['data'];
        return  $user->userName;
    }

    public static function getUserInfo($id){
       // $response = Request::doTheRequest('GET', 'API/identity/user/'.$id.'?d=professional_data&d=manager_id');
        $response = Request::doTheRequest('GET', 'API/identity/membership?p=0&c=10&f=user_id%3d'.$id.'&d=role_id');
        $user = $response['data'];
        return  $user;
    }

    public static function getCountUsers(){
        $response = Request::doTheRequest('GET', 'API/identity/user?p=0&c=1000&o=lastname%20ASC');
        return count($response['data']);
    }
}
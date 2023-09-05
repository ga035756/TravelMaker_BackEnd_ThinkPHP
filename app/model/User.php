<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;
use think\facade\Db;
;

/**
 * @mixin \think\Model
 */

class User extends Model
{
    protected $table = 'users'; // table name
    protected $pk = 'user_id';

    // login
    public function loginUser($userName)
    {
        return Db::table($this->table)->where('user_name', $userName)->find();
    }

    // 设置用户Token
    public function setToken($userName)
    {
        $token = md5(uniqid());
        Db::table($this->table)->where('user_name', $userName)->update(['token' => $token]);
        return $token;
    }

    // get用户全名
    public function getFullName($token)
    {
        return Db::table($this->table)->where('token', $token)->value('full_name');
    }

    // get用户ID
    public function getUserId($token)
    {
        return Db::table($this->table)->where('token', $token)->value('user_id');
    }

    public function registerUser($userName, $hashedPassword, $email, $birthday, $fullName, $nickName, $gender, $registerTime)
    {
        
        // call db procedure
        $result = DB::query("CALL register_user(?, ?, ?, ?, ?, ?, ?, ?)", [$userName, $hashedPassword, $email, $birthday, $fullName, $nickName, $gender, $registerTime]);

        // dd($result);
        $message = $result[0][0]['message'];
// echo($result[0]);
        return $message;
    }
}


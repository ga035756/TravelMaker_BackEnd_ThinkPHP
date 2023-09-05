<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $userName = $request->param('username');
        $password = $request->param('password');
        
        // use User Model to do login
        $userModel = new UserModel();
        $user = $userModel->loginUser($userName);
        if ($user && password_verify($password, $user['password'])) {
            $token = $userModel->setToken($userName);
            $fullName = $userModel->getFullName($token);
            $userId = $userModel->getUserId($token);

            $data = [
                "message" => "登入成功",
            ];

            if ($userName === "admin") {
                cookie('role', 'admin', ['expire' => 3600, 'path' => '/']);
            } else {
                cookie('role', 'user', ['expire' => 3600, 'path' => '/']);
            }

            cookie('token', $token, ['expire' => 3600, 'path' => '/']);
            cookie('username', $userName, ['expire' => 3600, 'path' => '/']);
            cookie('fullName', $fullName, ['expire' => 3600, 'path' => '/']);
            cookie('userId', $userId, ['expire' => 3600, 'path' => '/']);

            return json($data, 200);
        } else {
            return json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $userName = $request->param('username');
        $password = $request->param('password');
        $email = $request->param('email');
        $fullName = $request->param('fullName');
        $nickName = $request->param('nickName');
        $birthday = $request->param('birthday');
        $gender = $request->param('gender');

        date_default_timezone_set('Asia/Taipei');
        $registerTime = date("Y-m-d H:i:s");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userModel = new UserModel();

        // 检查重複用户名和email
        $checkDuplicateUsername = $userModel->where('user_name', $userName)->find();
        $checkDuplicateEmail = $userModel->where('email', $email)->find();

        if (empty($checkDuplicateUsername)) {
            if (empty($checkDuplicateEmail)) {
                // use User Model 中的 registerUser 
                $registerMessage = $userModel->registerUser($userName, $hashedPassword, $email, $birthday, $fullName, $nickName, $gender, $registerTime);
            } else {
                $registerMessage = '相同email已存在';
            }
        } else {
            $registerMessage = '相同帳號已存在';
        }

        $data = [
            "message" => $registerMessage
        ];

        return json($data, 200);
    }
}

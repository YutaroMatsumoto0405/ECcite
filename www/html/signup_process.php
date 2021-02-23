<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
// ログインしてたらログイントップにリダイレクト
if(is_logined() === true){
  redirect_to(LOGIN_TOP_URL);
}

// post送信された値を変数に格納
$name = get_post('name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');
$token = get_post('token'); 
// DBに接続する
$db = get_db_connect();


// 新規登録の処理
if(is_valid_csrf_token($token)){ 
    try{
        $result = regist_user($db, $name, $password, $password_confirmation);
        if($result=== false){
            set_error('ユーザー登録に失敗しました。');
            // 失敗したら登録画面にリダイレクト
            redirect_to(SIGNUP_URL); 
        }
    }catch(PDOException $e){
        set_error('ユーザー登録に失敗しました。');
        redirect_to(SIGNUP_URL);
} 
    set_message('ユーザー登録が完了しました。');
    login_as($db, $name, $password);
    // 登録に成功したらここに移動
    redirect_to(SIGNUP_RESULT_URL);
} else { 
    set_error('不正な操作が行われました'); 
} 

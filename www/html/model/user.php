<?php
require_once  './model/functions.php';
require_once  './model/db.php';
// ユーザー情報を取得
function get_user($db, $user_id){
  $sql = "
    SELECT
        user_id, 
        name,
        password
    FROM
        users
    WHERE
         user_id = ? 
    LIMIT 1
  ";
  return fetch_query($db, $sql,array($user_id));
}
// ユーザーの新規登録
function insert_user($db,$name,$password){
    $sql = "
        INSERT INTO
            users(
                name,
                password,
                createdate
            )
        VALUES(?,?,now()); 
    ";
    
    return execute_query($db,$sql,array($name,$password));
}
// ログインするユーザーの名前を取得 
function get_user_by_name($db, $name){
    $sql = "
      SELECT
          user_id, 
          name,
          password
      FROM
           users
      WHERE
          name = ? 
      LIMIT 1
    ";
  
    return fetch_query($db, $sql,array($name));
  }

// ログインしようとしてるユーザーが正しいかの処理
function login_as($db, $name, $password){
    $user = get_user_by_name($db, $name);
    if($user === false || $user['password'] !== $password){
        return false;
}
    set_session('user_id', $user['user_id']);
    return $user;
} 
// ログインユーザの情報取得
function get_login_user($db){
    $login_user_id = get_session('user_id');
    return get_user($db, $login_user_id);
}
// ユーザー登録、正しければ登録成功
function regist_user($db,$name,$password) {
    if(is_valid_user($name,$password) === false){
        return false;
    }
        return insert_user($db,$name,$password);
}
// 管理者、IDは１
function is_admin($user){
    return $user['user_id'] === USER_ID_ADMIN;
}

function is_valid_user($name,$password){
    // 文字数、型チェックを代入
    $is_valid_user_name = is_valid_user_name($name);
    $is_valid_password = is_valid_password($password);
    return $is_valid_user_name && $is_valid_password ;
}

// 登録時の名前の文字数と半角英数字かを確認、function
function is_valid_user_name($name) {
    $is_valid = true;
    if(is_valid_length($name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false){
        set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にしてください。');
        $is_valid = false;
    }
    if(is_alphanumeric($name) === false){
        set_error('ユーザー名は半角英数字で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
}

// 登録時のパスワードの文字数と半角英数字かどうかを確認
function is_valid_password($password){
    $is_valid = true;
    if(is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false){
        set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
        $is_valid = false;
    }
    if(is_alphanumeric($password) === false){
        set_error('パスワードは半角英数字で入力してください。');
        $is_valid = false;
    }
    return $is_valid;
}


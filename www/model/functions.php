<?php
// 非ログイン時はログインページにリダイレクト
function redirect_to($url){
    header('Location:' . $url);
    exit;
}

// getで送られてきた値の確認と返し
function get_get($name){
    if(isset($_GET[$name]) === true){
      return $_GET[$name];
    };
    return '';
}
// postで送られてきた値の確認と返し
function get_post($name){
    if(isset($_POST[$name]) === true){
        return $_POST[$name];
    };
    return '';
}

// アップロードされた値の取得、確認
function get_file($name){
    if(isset($_FILES[$name]) === true){
        return $_FILES[$name];
    };
    return array();
}

// セッションから値を取得
function get_session($name){
    if(isset($_SESSION[$name]) === true){
      return $_SESSION[$name];
    };
    return '';
}

function set_session($name, $value){
    $_SESSION[$name] = $value;
}

// エラーメッセージの格納
function set_error($error){
    $_SESSION['__errors'][] = $error;
}
  
function get_errors(){
    $errors = get_session('__errors');
    if($errors === ''){
        return array();
    }
    set_session('__errors',  array());
    return $errors;
}

// エラーの確認
function has_error(){
    // セッションにエラーが1つ以上あればtrue
    return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

// 成功メッセージ
function set_message($message){
    $_SESSION['__messages'][] = $message;
}

function get_messages(){
    $messages = get_session('__messages');
    if($messages === ''){
        return array();
    }
    set_session('__messages',  array());
    return $messages;
}

// ログイン済みかどうかの確認
function is_logined(){
    return get_session('user_id') !== '';
}

// ファイルのアップロード
function get_upload_filename($file){
    if(is_valid_upload_image($file) === false){
        return '';
    }
    // 拡張子
    $mimetype = exif_imagetype($file['tmp_name']);
    // あとで変数と定数の確認
    $ext = PERMITTED_IMAGE_TYPES[$mimetype];
    return get_random_string() . '.' . $ext;
}

// 20文字の乱数
function get_random_string($length = 20){
    return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}
   
function save_image($image, $filename){
    return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}
  
function delete_image($filename){
    if(file_exists(IMAGE_DIR . $filename) === true){
        unlink(IMAGE_DIR . $filename);
      return true;
    }
    return false;
}
  
// 長さの確認
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
    $length = mb_strlen($string);
    return ($minimum_length <= $length) && ($length <= $maximum_length);
}

// 文字のフォーマット
function is_alphanumeric($string){
    return is_valid_format($string, REGEXP_ALPHANUMERIC);
}
function is_valid_format($string, $format){
    return preg_match($format, $string) === 1;
}

// 正の整数かどうか
function is_positive_integer($string){
    return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

// アップロードする画像の形式確認
function is_valid_upload_image($image){
    if(is_uploaded_file($image['tmp_name']) === false){
        set_error('ファイル形式が不正です。');
        return false;
    }
    // 画像の情報
    $mimetype = exif_imagetype($image['tmp_name']);
    if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
        // implodeで連結
        set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
      return false;
    }
    return true;
}
  
// エスケープ処理
function h($text){ 
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); 
} 

// 必要に応じてcut、空白削除をここに書く

  
// トークンの生成 
function get_csrf_token(){ 
    $token = get_random_string(30); 
    set_session('csrf_token', $token); 
    return $token; 
} 
  
// トークンのチェック 
function is_valid_csrf_token($token){ 
    if($token === '') { 
        return false; 
    } 
    return $token === get_session('csrf_token'); 
} 

?>
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
// エラー呼び出し
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
// 成功メッセージの呼び出し
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
    // ファイルが画像かどうか判断
    $mimetype = exif_imagetype($file['tmp_name']);
    // jpgかpngを定数で代入
    $ext = PERMITTED_IMAGE_TYPES[$mimetype];
    return get_random_string() . '.' . $ext;
}
// 20文字の乱数
function get_random_string($length = 20){
    return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}
// 登録した商品の保管場所
function save_image($image, $filename){
    return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}
// 商品画像の削除、第一引数にファイルのパス、第二に画像の名前
function delete_image($filename){
    if(file_exists(IMAGE_DIR . $filename) === true){
        unlink(IMAGE_DIR . $filename);
      return true;
    }
    return false;
}
// 長さの確認、上限確認
function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
    $length = mb_strlen($string);
    // 最少以上、最多以下
    return ($minimum_length <= $length) && ($length <= $maximum_length);
}
// 文字のフォーマット
function is_alphanumeric($string){
    return is_valid_format($string, REGEXP_ALPHANUMERIC);
}
function is_valid_format($string, $format){
    return preg_match($format, $string) === 1;
}
// 正の整数かどうか、正規表現
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
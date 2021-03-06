<?php
require_once  './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';
require_once  './model/cart.php';

session_start();

// 変数に格納
$token = get_csrf_token(); 
$db = get_db_connect();
$user = get_login_user($db);
// 検索された値の格納
$search = get_post('search');
// カテゴりが空の時も
$category = get_post('category');

// 検索orカテゴリが押された時
if(is_valid_csrf_token($token)){ 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $sqltype = get_post('sqltype');
            if($sqltype === 'search'){
                $items = push_search($db,$search);
            } else if($sqltype === 'category'){
                $items = push_category($db,$category);
            }
    // 遷移時（GET）はこれを表示
    }else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $items = get_open_items($db);
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $_SESSION['__errors'] = array();
}

include_once VIEW_PATH . 'top_view.php'; 
?>

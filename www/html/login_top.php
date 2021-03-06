<?php
require_once './conf/const.php';
require_once  './model/functions.php';
require_once  './model/user.php';
require_once  './model/item.php';

session_start();
// ログインしていなかったら、login画面へリダイレクト
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
// トークン
$token = get_csrf_token(); 
// DBに接続する
$db = get_db_connect();
$user = get_login_user($db);
// 検索された値の格納
$search = get_post('search');
// カテゴりが空の時も
$category = get_post('category');

$sqltype = get_post('sqltype');

// 検索結果をソートする
if($sqltype !== 'sort'){
  if(!empty($search)){
    $_SESSION['search'] = $search;
  } else{
    unset($_SESSION['search']);
  }
// カテゴリ表示をソートする
if(!empty($category)){
  $_SESSION['category'] = $category;
} else{
  unset($_SESSION['category']);
}
}

if(is_valid_csrf_token($token)){ 
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // 検索
    if($sqltype === 'search'){
        $items = push_search($db,$search);
    // カテゴリ
    } else if($sqltype === 'category'){
        $items = push_category($db,$category);
    // ソートが押されたら
    } else if($sqltype === 'sort'){
      $sort = get_post('sort');
      if(empty($_SESSION['search']) && empty($_SESSION['category'])){
        $items = get_open_items($db,$sort);
      // 検索結果をソート
      } else if(!empty($_SESSION['search'])){
        $items = push_search($db,$_SESSION['search'],$sort);
      // カテゴリ検索をソート
      } else if(!empty($_SESSION['category'])){
        $items = push_category($db,$_SESSION['category'],$sort);
      }
    }
  } else if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $items = get_open_items($db);
  }
}    

// viewファイル出力
include_once VIEW_PATH . 'login_top_view.php';
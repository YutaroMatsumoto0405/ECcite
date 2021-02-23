<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'favorite.php';

session_start();
if(is_logined() === false){
    redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
// postで受け取り
$item_id = get_post('item_id');

// クリックされた商品の詳細をselect
$item_details = get_item($db, $item_id);

// favoriteをselectして登録されてる時とまだされてないときの分岐
$check_favorite = check_favorite($db,$user['user_id'],$item_id);

include_once VIEW_PATH . 'details_item_view.php';

// get_item_detailsがされた時点で、check_favoriteも行う、入ってたらお気に入りから外す、入ってなかったらお気に入りに追加をおす

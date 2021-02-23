<?php

define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');


define('IMAGE_PATH', '/asset/item_img/');
define('STYLESHEET_PATH', '/assets/css/');
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' );
 
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8'); 
 
define('SIGNUP_URL', '/signup.php');
define('SIGNUP_RESULT_URL', '/signup_result.php');
define('LOGIN_URL', '/login.php');
define('LOGIN_TOP_URL', '/login_top.php');
define('LOGOUT_URL', '/logout.php');
define('HOME_URL', '/top.php');
define('CART_URL', '/cart.php');
define('FINISH_URL', '/finish.php');
define('ADMIN_URL', '/admin.php');

// 文字のフォーマットチェック用、必要に応じて0以上の半角数字の条件を追加
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');

// ユーザー名、パスワードは6文字以上100文字以下
define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 100);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

// 管理者かユーザか
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2); 

define('USER_ID_ADMIN', 4);

// 追加登録できる商品、名前の文字数
define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 100);

// 追加商品の詳細文字数
define('ITEM_COMMENT_LENGTH_MIN', 1);
define('ITEM_COMMENT_LENGTH_MAX', 200);

// 商品の公開、非公開ステータス
define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);

// 商品のカテゴリ
define('ITEM_CATEGORY_MEN', 0);
define('ITEM_CATEGORY_WOMAN', 1);
define('ITEM_CATEGORY_KIDS', 2);
define('ITEM_CATEGORY_COLOR', 3);
define('ITEM_CATEGORY_SIMPLE', 4);

// ステータスの種類
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));

// 画像はjpg、pngだけ追加できる
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));

// 許可するカテゴリの種類
define('PERMITTED_ITEM_CATEGORY', array(
  ITEM_CATEGORY_MEN => 0,
  ITEM_CATEGORY_WOMAN => 1,
  ITEM_CATEGORY_KIDS => 2,
  ITEM_CATEGORY_COLOR => 3,
  ITEM_CATEGORY_SIMPLE => 4,
));

<?php

$name = 0;
$price = 0;
$img = '';
$img_dir = './img/';
$new_img = '';
$new_img_filename = '';
$stock = 0;
$date = date('Y-m-d H:i:s');
$data = array();
$err_msg =[];
$success_msg = [];

function html_enc($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function cut($space)
{
    return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $space);
}


$host     = 'localhost';
$username = 'codecamp41224';   
$password = 'codecamp41224';       
$dbname   = 'codecamp41224';
$charset  = 'utf8';   
 
    
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
 
try {
     
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
            
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['sql_type']) === TRUE) {
        $sql_type = $_POST['sql_type'];
    }
    if($sql_type === 'insert') {
        
        if(isset($_POST['name']) === TRUE){
            $name = $_POST['name'];
                if (mb_strlen($name) === 0 || cut($name) === '') {
                    $err_msg[]  = '商品名を入力してください';
                } 
        }
        
        if(isset($_POST['price']) === TRUE){
            $price = $_POST['price'];
                if (mb_strlen($price) === 0) {
                    $err_msg[]  = '値段を入力してください';
                    // preg_matchは0か1を返す
                } else if (preg_match('/^[0-9]+$/',$price) !== 1){
                    $err_msg[]  = '値段は0以上の半角数字で入力してください';
                }
        }
        
        if(isset($_POST['stock']) === TRUE){
            $stock = $_POST['stock'];
                if (mb_strlen($stock) === 0) {
                    $err_msg[]  = '個数を入力してください';
                } else if (preg_match('/^[0-9]+$/',$stock) !== 1) {
                    $err_msg[]  = '個数は0以上の半角数字で入力してください';
                }
        }
        
        
        if(isset($_POST['new_status']) === TRUE){
            // 文字列
            if($_POST['new_status'] === '0' || $_POST['new_status'] === '1'){
                $status = $_POST['new_status'];
            }else {
                $err_msg[] = 'ステータスは公開か非公開を選択してください';
            }
         }
        
        // カテゴリ
        if(isset($_POST['new_category']) === TRUE){
            if($_POST['new_category'] === '0' || $_POST['new_category'] === '1' || $_POST['new_category'] === '2' || $_POST['new_category'] === '3' || $_POST['new_category'] === '4'){
                $category = $_POST['new_category'];
            }else {
                $err_msg[]  = 'カテゴリを選択してください';
            } 
        }
        
        // コメント
        if(isset($_POST['comment']) === TRUE){
            $comment = $_POST['comment'];
                if (mb_strlen($comment) === 0 || cut($comment) === '') {
                    $err_msg[]  = '商品情報を入力してください';
                } 
        }
        
            
        
        // アップロード画像ファイルの保存
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (is_uploaded_file($_FILES['new_img']['tmp_name']) === TRUE) {
            $extension = pathinfo($_FILES['new_img']['name'], PATHINFO_EXTENSION);
                if ($extension === 'png' || $extension === 'jpeg'  || $extension === 'jpg') {
                    $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
                        if (is_file($img_dir . $new_img_filename) !== TRUE) {
                            if (move_uploaded_file($_FILES['new_img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                                $err_msg[] = 'ファイルアップロードに失敗しました';
                            }
                        } else {
                            $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                        }
                } else {
                    $err_msg[] = 'PNGかJPEG形式のファイルをアップロードしてください。';
                }
            } else {
                $err_msg[] = 'ファイルを選択してください';
            }
        }
        
        
        try {
            // 商品情報テーブル
            if(count($err_msg) === 0 ) {
                $sql = 'insert into items(name , price , img , status , stock , category , comment , createdate , updatedate) values(?,?,?,?,?,?,?,?,?)';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$name, PDO::PARAM_STR);
                $stmt->bindValue(2,$price, PDO::PARAM_INT);
                $stmt->bindValue(3,$new_img_filename, PDO::PARAM_STR);
                $stmt->bindValue(4,$status, PDO::PARAM_INT);
                $stmt->bindValue(5,$stock, PDO::PARAM_STR);
                $stmt->bindValue(6,$category, PDO::PARAM_STR);
                $stmt->bindValue(7,$comment, PDO::PARAM_STR);
                $stmt->bindValue(8,$date, PDO::PARAM_INT);
                $stmt->bindValue(9,$date, PDO::PARAM_INT);
                $stmt->execute();
                
                $success_msg[] = '商品の追加が完了しました';
                
            }
           
            
        } catch (PDOException $e) {
           
            throw $e;
        }

    // 在庫管理
    } else if ($sql_type === 'update_stock'){
        if(isset($_POST['id']) === TRUE){
            $update_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['stock']) === TRUE) {
            $update_stock = $_POST['stock'];
            if (preg_match('/^[0-9]+$/',$update_stock) !== 1) {
                $err_msg[]  = '個数は0以上の半角数字で入力してください';
            } 
            
            if(count($err_msg) === 0) {
                try {
                    $sql =  'UPDATE items 
                            SET stock = ?,
                            updatedate = ?
                            WHERE id = ?';
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1,$update_stock, PDO::PARAM_STR);
                    $stmt->bindValue(2,$date, PDO::PARAM_INT);
                    $stmt->bindValue(3,$update_id, PDO::PARAM_INT);
                    $stmt->execute();
                
                    $success_msg[] = '在庫数の変更が完了しました';
                
                } catch (PDOException $e) {
                    $dbh->rollback();
                    throw $e;
                }
            }
        }
        
    // ステータス変更
    } else if ($sql_type === 'change_status'){
        if(isset($_POST['id']) === TRUE){
            $change_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['status']) === TRUE) {
            $change_status = $_POST['status'];
            
            if($change_status === '0' || $change_status === '1'){
                $success_msg[] = 'ステータスの変更が完了しました';
            } else{
                $err_msg[]  = 'ステータスの変更に失敗しました';
            }        
        
        
            if(count($err_msg) === 0) {
            try {
            // シングルクォーテーションで囲んだ変数に注意！
                $sql = 'UPDATE items
                        SET status = ' . $change_status . ',
                            updatedate = ?
                        WHERE id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$date, PDO::PARAM_INT);
                $stmt->bindValue(2,$change_id, PDO::PARAM_INT);
                $stmt->execute();
                
                
            } catch (PDOException $e) {
                $dbh->rollback();
                throw $e;
            }
            }
        
        }

    // カテゴリ選択
    } else if ($sql_type === 'choice_category'){
        if(isset($_POST['id']) === TRUE){
            $change_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['category']) === TRUE) {
            $choice_category = $_POST['category'];
        
            if($choice_category === '0' || $choice_category === '1' || $choice_category === '2' || $choice_category === '3' || $choice_category === '4'){
                $success_msg[] = 'カテゴリの変更が完了しました';
            } else{
                $err_msg[]  = 'カテゴリの変更に失敗しました';
            }        
          
            if(count($err_msg) === 0) {
            try {
            // シングルクォーテーションで囲んだ変数に注意！
                $sql = 'UPDATE items
                        SET category = ' . $choice_category . ',
                            updatedate = ?
                        WHERE id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$date, PDO::PARAM_INT);
                $stmt->bindValue(2,$change_id, PDO::PARAM_INT);
                $stmt->execute();
                
                
            } catch (PDOException $e) {
                $dbh->rollback();
                throw $e;
            }
            }
        
        }

    // 詳細追加
    } else if ($sql_type === 'add_comment'){
        if(isset($_POST['id']) === TRUE){
            $change_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['comment']) === TRUE) {
            $add_comment = $_POST['comment'];
        
            if(mb_strlen($add_comment) === 0 || cut($name) === '') {
                $err_msg[]  = '商品詳細の変更に失敗しました';
            } else{
                $success_msg[] = '商品詳細を変更しました';
            }        
        
            if(count($err_msg) === 0) {
            try {
            // シングルクォーテーションで囲んだ変数に注意！
                $sql = 'UPDATE items
                        SET comment = ?,
                            updatedate = ?
                        WHERE id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$add_comment, PDO::PARAM_STR);
                $stmt->bindValue(2,$date, PDO::PARAM_INT);
                $stmt->bindValue(3,$change_id, PDO::PARAM_INT);
                $stmt->execute();
                
                
            } catch (PDOException $e) {
                $dbh->rollback();
                throw $e;
            }
            }
        }
        
        
    // 削除
      } else if($sql_type === 'data_delete') {
        if(isset($_POST['id']) === TRUE) {
            $change_id = $_POST['id'];
        } else {
            $err_msg[] = '不正な処理です';
        }
        if(isset($_POST['delete']) === TRUE) {
            $delete = $_POST['delete'];
            $success_msg[] = '削除しました';
            
            
        if(count($err_msg) === 0) {
            try {
                $sql = 'DELETE 
                        FROM items
                        WHERE id = ?';
                        
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1,$change_id, PDO::PARAM_INT);
                $stmt->execute();
                   
            } catch (PDOException $e) {
                $dbh->rollback();
              throw $e;
              
            }
        }
        }
      }
}

// 位置に注意！　if文の中に入れると、ボタン押さないと初期画面で表示されない
$sql = 'select id,name,price,img,status,stock,category,comment from items';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll();
$data = $rows;
  
} catch (PDOException $e) {
    echo '接続できませんでした。理由：'.$e->getMessage();
}

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    <style type="text/css">
        img{
            width: 150px;
        }
        .close{
            background-color: gray;
        }
    </style>
</head>
<body>
    
    <h1>商品管理</h1>
    
    <hr width="100%" solid>
    
<ul>
        <?php foreach ($err_msg as $remark) { ?>
            <li>
                <?php print $remark ?>
            </li>
        <?php } ?>
</ul>

<ul>
        <?php foreach ($success_msg as $remark) { ?>
            <li>
                <?php print $remark ?>
            </li>
        <?php } ?>
</ul>
    
    <h2>新規商品追加</h2>
    
        <form method="post" enctype="multipart/form-data">
            <p> 名前 : <input type="text" name="name" ></p>
            <p> 値段 : <input type="text" name="price"></p>
            <p> 個数 : <input type="text" name="stock"></p>
            <p><input type="file" name="new_img" accept="image/jpeg, image/png , image/jpg"></p>
            <select name = new_status>
                <option value="1">公開</option>
                <option value="0">非公開</option>
            </select><br>
            <select name = new_category>
                <option value="0">men</option>
                <option value="1">woman</option>
                <option value="2">kids</option>
                <option value="3">color</option>
                <option value="4">simple</option>
            </select><br>
            <p> 詳細 : <textarea name="comment" rows="3" cols="30" wrap="hard"></textarea> </p>
            <input type="hidden" name="sql_type" value="insert">
            <p><input type="submit" value="商品を追加"></p>
        </form>
        
    <hr width="100%" solid>
    
    <h2>商品情報変更</h2>
    
    <p>商品一覧</p>
    
    <table border="1" width="80%">
        <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>ステータス</th>
            <th>カテゴリ</th>
            <th>詳細</th>
            <th>削除</th>
        </tr>
        
<?php foreach ($data as $value) { ?>

        <?php if($value['status'] === 1) { ?>
        <tr align = "center">
        <?php } else { ?>
        <tr align = "center" class="close">
        <?php }  ?>
             <!--カラム名-->
            <td><img src=" <?php print $img_dir . $value['img']; ?>"></td>
            <td><?php print html_enc($value['name']); ?></td>
            <td><?php print $value['price']; ?></td>
            <td>
                <form method="post">
                    <input type="text" name="stock" value = "<?php print $value['stock'] ; ?>" ><label>個</label>
                    <input type="hidden" name="sql_type" value="update_stock">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="submit" value="変更">
                </form>
                
        <?php if($value['status'] === 1) { ?>
            <td>
                <form method="POST" >
                    <input type="submit" value="公開→非公開">
                    <input type="hidden" name="status" value="0" >
                    <input type="hidden" name="sql_type" value="change_status" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
        <?php } else { ?>
            <td>
                <form method="POST">
                    <input type="submit" value="非公開→公開">
                    <input type="hidden" name="status" value="1" >
                    <input type="hidden" name="sql_type" value="change_status" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
        <?php } ?>
        
        
        
        <?php if($value['category'] === 0) { ?>
            <td>
                <form method="POST">
                    <select name = category onchange="submit(this.form)">
                        <option value="0">men</option>
                        <option value="1">woman</option>
                        <option value="2">kids</option>
                        <option value="3">color</option>
                        <option value="4">simple</option>
                    </select>
                    <input type="hidden" name="sql_type" value="choice_category" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
        <?php } else if($value['category'] === 1) { ?>
            <td>
                <form method="POST">
                    <select name = category onchange="submit(this.form)">
                        <option value="1">woman</option>
                        <option value="0">men</option>
                        <option value="2">kids</option>
                        <option value="3">color</option>
                        <option value="4">simple</option>
                    </select>
                    <input type="hidden" name="sql_type" value="choice_category" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
        <?php }else if($value['category'] === 2) { ?>
            <td>
                <form method="POST">
                    <select name = category onchange="submit(this.form)">
                        <option value="2">kids</option>
                        <option value="0">men</option>
                        <option value="1">woman</option>
                        <option value="3">color</option>
                        <option value="4">simple</option>
                    </select>
                    <input type="hidden" name="sql_type" value="choice_category" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
         
        <?php }else if($value['category'] === 3) { ?>
            <td>
                <form method="POST">
                    <select name = category onchange="submit(this.form)">
                        <option value="3">color</option>
                        <option value="0">men</option>
                        <option value="1">woman</option>
                        <option value="2">kids</option>
                        <option value="4">simple</option>
                    </select>
                    <input type="hidden" name="sql_type" value="choice_category" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
         
        <?php }else if($value['category'] === 4) { ?>
            <td>
                <form method="POST">
                    <select name = category onchange="submit(this.form)">
                        <option value="4">simple</option>
                        <option value="0">men</option>
                        <option value="1">woman</option>
                        <option value="2">kids</option>
                        <option value="3">color</option>
                    </select>
                    <input type="hidden" name="sql_type" value="choice_category" >
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                </form>
            </td>
         
        <?php } ?>
        
            <td>
                <form method="POST">
                    <textarea name="comment" rows="3" cols="30" wrap="hard"><?php print $value['comment']; ?></textarea>
                    <input type="hidden" name="sql_type" value="add_comment">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="submit" value="変更">
                </form>
            </td>
            <td>
                <form method="POST">
                    <input type="hidden" name="sql_type" value="data_delete">
                    <input type="hidden" name="id" value="<?php print $value['id']; ?>">
                    <input type="submit" name="delete" value="削除">
                </form>
            </td>
        </tr>
<?php } ?>
    
    </table>
    
</body>
</html>
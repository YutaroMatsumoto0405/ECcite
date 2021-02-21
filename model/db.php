<?php

// データベースに接続
function get_db_connect(){
    // あとで定数constに変える
    $dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;

    try {
        // あとで定数に変える
        $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        echo '接続できませんでした。理由：'.$e->getMessage();
    }
    return $dbh;
}

// 単一行の取得、select
function fetch_query($db,$sql,$param = array()) {
    try{
        $statement = $db->prepare($sql);
        $statement->execute($params);
        return $statement->fetch();
    } catch(PDOException $e) {
        set_error('データ取得に失敗しました');
    }
    return false;
}

// 全データ取得、select
function fetch_all_query($db, $sql, $params = array()){
    try{
      $statement = $db->prepare($sql);
      $statement->execute($params);
      return $statement->fetchAll();
    }catch(PDOException $e){
      set_error('データ取得に失敗しました。');
    }
    return false;
  }

// update、delete、insert
function execute_query($db, $sql, $params = array()){
    try{
      $statement = $db->prepare($sql);
      return $statement->execute($params);
    }catch(PDOException $e){
      set_error('更新に失敗しました。');
    }
    return false;
  }








?>
history

1.注文番号(オートインクリメント)
2.userid

3.購入日時


buy_detail

1.注文番号(オートインクリメント)
3.itemid
2.数量
4.金額

-- 購入履歴画面テーブル
CREATE TABLE history(
  order_id INT(11) AUTO_INCREMENT,
  user_id INT(11),
  buy_date DATETIME,
  primary key(order_id)
);
-- 購入明細画面テーブル
CREATE TABLE details(
  order_id INT(11) ,
  item_id INT(11),
  amount INT(11) ,
  price INT(11) ,
);
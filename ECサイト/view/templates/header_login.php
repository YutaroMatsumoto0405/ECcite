<link rel="stylesheet" href="html5reset-1.6.1.css">
    <style type="text/css">

        .top {
            background-color: #E1DCDC;
        }    
        header {
            width: 960px;
            margin: 0 auto;      
        }
        .logo {
            text-align: center;
            padding: 10px 0;
        }
        .logo>img {
            padding: 10px 0;
        }
        header ul {
            display: flex;
            justify-content: space-around;
            list-style: none;
            margin: 10px 0;
            padding-left: 0;
        }
        header ul a {
            text-decoration: none;
            display: block;
            color: #222222;
        }
        header ul li {
            flex: 1;
            text-align: center;
            font-size: 19px;
            padding-bottom: 3px;
        }
        header ul li+li {
            border-left: solid 1px #cccccc;
        }
    </style>

<div class="top">
    <header>
        <div class="logo">
            <img src="logo.top.jpg">
        </div>
        <ul>
            <li class="home"><a href="login_top.php">ホーム</a></li>
            <li class="register"><a href="cart.php">買い物かご</a></li>
            <li class="login"><a href="history.php">購入履歴</a></li>
            <li class="login"><a href="favorite.php">お気に入り</a></li>
            <li class="cart"><a href="logout.php">ログアウト</a></li>
        </ul>
    </header>
</div>

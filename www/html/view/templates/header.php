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
        <img src="<?php print IMAGE_PATH_LOGO . 'logo.top.jpg'; ?>" >
        </div>
        <ul>
            <li class="home"><a href="top.php">ホーム</a></li>
            <li class="register"><a href="signup.php">新規登録</a></li>
            <li class="login"><a href="login.php">ログイン</a></li>
        </ul>
    </header>
</div>
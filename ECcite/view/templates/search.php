<link rel="stylesheet" href="html5reset-1.6.1.css">
    <style type="text/css">
        nav {
            width: 210px;
            padding-right: 20px;
        }
        nav ul li {
            border-bottom: dotted 1px #DDDDDD;
            margin: 15px 0;
            font-size: 18px;
            list-style: none;
        }
        nav ul li a {
            text-decoration: none;
            color: #333333;
        }
        .frame1 {
            padding-bottom: 60px;
        }
        h2 {
            text-align: center;
            padding-bottom: 15px;
        }
        .search {
            height: 23px;
            border-radius: 10px;
        }
    </style>
<nav> 
    <div class="frame1">
    <h2>SEARCH</h2>
    
    <form action="top.php" method="post">
        <input type="text" name="name">
        <input type="hidden" name="token" value="<?php print $token ?>">
        <input type="submit" value="探す" />
    </form>
    </div>
    <div class="frame">
    <h2>CATEGORY</h2>
    <ul>
        
        <form method="post" name="men" action="top.php">
            <li><a href="javascript:men.submit()">men</a></li>
            <input type="hidden" name="category" value="0">
        </form>

        <form method="post" name="woman" action="top.php">
            <li><a href="javascript:woman.submit()">woman</a></li>
            <input type="hidden" name="category" value="1">
        </form>

        <form method="post" name="kids" action="top.php">
            <li><a href="javascript:kids.submit()">kids</a></li>
            <input type="hidden" name="category" value="2">
        </form>

        <form method="post" name="color" action="top.php">
            <li><a href="javascript:color.submit()">color</a></li>
            <input type="hidden" name="category" value="3">
        </form>

        <form method="post" name="simple" action="top.php">
            <li><a href="javascript:simple.submit()">simple</a></li>
            <input type="hidden" name="category" value="4">
        </form>
        
    </div>
    </ul>
    
</nav>

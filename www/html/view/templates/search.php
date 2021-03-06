<link rel="stylesheet" href="html5reset-1.6.1.css">
    <style type="text/css">
        nav { 
            width: 210px;
            padding-right: 20px; 
            float:left; 
        }
        nav ul li {
            border-bottom: dotted 1px #DDDDDD;
            margin: 30px 0;
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
            padding-bottom: 30px;
        }
        .search {
            height: 23px;
            border-radius: 10px;
        }

    </style>

<nav> 
    <div class="frame1">
    <h2>SEARCH</h2>
    
    <form method="post" action="top.php">
        <input type="search" name="search"> 
        <input type="hidden" name="sqltype" value="search">
        <input type="hidden" name="token" value="<?php print $token ?>">
        <input type="submit" value="探す" />
    </form>
    </div>
    <div class="frame">
    <h2>CATEGORY</h2>
    <ul>
        
        <form method="post" name="men" action="top.php">
            <li><a href="javascript:men.submit()">men</a></li>
            <input type="hidden" name="category" value="<?php print ITEM_CATEGORY_MEN ?>">
            <input type="hidden" name="sqltype" value="category">
        </form>

        <form method="post" name="woman" action="top.php">
            <li><a href="javascript:woman.submit()">woman</a></li>
            <input type="hidden" name="category" value="<?php print ITEM_CATEGORY_WOMAN ?>">
            <input type="hidden" name="sqltype" value="category">
        </form>

        <form method="post" name="kids" action="top.php">
            <li><a href="javascript:kids.submit()">kids</a></li>
            <input type="hidden" name="category" value="<?php print ITEM_CATEGORY_KIDS ?>">
            <input type="hidden" name="sqltype" value="category">
        </form>

        <form method="post" name="color" action="top.php">
            <li><a href="javascript:color.submit()">color</a></li>
            <input type="hidden" name="category" value="<?php print ITEM_CATEGORY_COLOR ?>">
            <input type="hidden" name="sqltype" value="category">
        </form>

        <form method="post" name="simple" action="top.php">
            <li><a href="javascript:simple.submit()">simple</a></li>
            <input type="hidden" name="category" value="<?php print ITEM_CATEGORY_SIMPLE ?>">
            <input type="hidden" name="sqltype" value="category">
        </form>
        
    </div>
    </ul>
    
</nav>

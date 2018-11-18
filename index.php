<!DOCTYPE html>

<?php
include("PHP/connect.php");
include("PHP/Mysql.class.php");
include("PHP/MysqlStatement.class.php");
?>

<html>
<head>
    <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery Mobile stylesheets -->
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <!-- Include the jQuery library -->
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <!-- Include the jQuery Mobile library -->
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>



<?php
/**
 * DEBUG:
 * echo $MysqlStatement_delete->sql; Anzeige SQL Statement
 */

/* get the mysql object */
$Mysql = new Mysql();

//SELECT * FROM user WHERE name="matthias";



if(isset($_POST[name]) && ($_POST[name] != null)){
    $sql = "SELECT * FROM user WHERE name=:0";
    $MysqlStatement_select_user = $Mysql->getMysqlStatement($sql);
    $MysqlStatement_select_user->execute($_POST[name]);
    $user = $MysqlStatement_select_user->fetchArray();
}

//get the user data
if(isset($user['id'])){
    $sql = "SELECT * FROM userdata WHERE user_id=:0";
    $MysqlStatement_select_data = $Mysql->getMysqlStatement($sql);
    $MysqlStatement_select_data->execute($user['id']);
}
?>

<div data-role="page" id="pageone">
    <div data-role="header">
        <h1>User Data</h1>

    </div>

    <div data-role="main" class="ui-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
            Name: <input type="text" name="name"><br>
            <input type="submit" value="Show me">
        </form>


    <?php
    if($MysqlStatement_select_data != null){
        while ($user_data = $MysqlStatement_select_data->fetchArray()) {
            echo "<br /> <div style='color:dodgerblue;'>Film: " . $user_data['movie'] . "</div>";
            echo "<label for='slider'>Rating (User):</label>";
            echo "<input data-theme=\"b\" type='range' name='slider' id='slider' value='".$user_data['rating']."' min='0' max='5'>";
        }
    }
    ?>
    </div>

</div>


</body>
</html>


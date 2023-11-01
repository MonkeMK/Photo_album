<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="accountCreation.php" method="POST">
        <label for="userName">User Name</label>
        <input type="text" name="userName" id="username"><br>
        <label for="passWord">Password</label>
        <input type="text" name="passWord" id='password'><br>
        <input type="submit">
    </form>
    <?php
    if(isset($_GET['error'])){
        if($_GET['error'] == 'emptyfields'){
            echo 'Please fill in all fields';
        }
    }
    ?>
</body>
</html>
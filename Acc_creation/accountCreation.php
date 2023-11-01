<html>
    <?php
    require '../dbconnect.php';
    if(!isset($_POST['userName']) || !isset($_POST['passWord']) || empty($_POST['userName']) || empty($_POST['passWord'])){
        header("Location: accountCreator.php?error=emptyfields");
    } else {
        $stmt = $conn->prepare('INSERT INTO accounts (username, password) VALUES (:username, :password)');
        $stmt->bindParam(':username', $_POST['userName']);
        $hashedpass = password_hash($_POST['passWord'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedpass);
        $stmt->execute();
        header("Location: ../index.php?username=".$_POST['userName']."&password=".$_POST['passWord']."");
    }
    ?>
</html>
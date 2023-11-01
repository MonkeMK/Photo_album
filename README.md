# Photo_album
Eigen drive

# Maybes:
Extra security toevoegen door:

session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false) {
    if (!isset($_GET['username']) || !isset($_GET['password'])) {
        header("Location: https://www.google.com/search?q=why+am+i+stupid&rlz=1C1UEAD_nlNL969NL969&oq=why+am+i+stupid&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBCDE4MzdqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8");
    } else {
        require 'dbconnect.php';
        $stmt = $conn->prepare('SELECT username, password FROM accounts WHERE username = :username');
        $stmt->bindParam(':username', $_GET['username']);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (password_verify($_GET['password'], $result[0]['password'])) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $_GET['username'];
            $_SESSION['password'] = $_GET['password'];
            header("Location: index.php");
        } else {
            header("Location: https://www.google.com/search?q=why+am+i+stupid&rlz=1C1UEAD_nlNL969NL969&oq=why+am+i+stupid&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBCDE4MzdqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8");
        }
    }
} else {
    $stmt = $conn->prepare('SELECT username, password FROM accounts WHERE username = :username');
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (password_verify($_SESSION['password'], $result[0]['password'])) {
            $_SESSION['loggedIn'] = true;
            header("Location: index.php");
        } else {
            $_SESSION['loggedIn'] = false;
            header("Location: https://www.google.com/search?q=why+am+i+stupid&rlz=1C1UEAD_nlNL969NL969&oq=why+am+i+stupid&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBCDE4MzdqMGoxqAIAsAIA&sourceid=chrome&ie=UTF-8");
        }
}

In session check te zetten ipv oude
<?php declare(strict_types=1);

require __DIR__.'/../autoload.php';

$userId = $_SESSION['user']['user_id'];

if (isset($_GET['user_id'])){

    $followingId = $_GET['user_id'];

    $statement = $pdo->prepare('SELECT * FROM follower WHERE user_id_1 = :user_id_1 AND user_id_2 = :user_id_2');

    if (!$statement) {
    die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':user_id_1', $userId, PDO::PARAM_INT);
    $statement->bindParam(':user_id_2', $followingId, PDO::PARAM_INT);

    $statement->execute();

    $following = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$following) {
        
        $query = 'INSERT INTO follower (user_id_1, user_id_2) VALUES (:user_id_1, :user_id_2)';

        $statement = $pdo->prepare($query);
       
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
    
        $statement->bindParam(':user_id_1', $userId, PDO::PARAM_INT);
        $statement->bindParam(':user_id_2', $followingId, PDO::PARAM_INT);
        
        $statement->execute();

        redirect("/my-posts.php?user_id=" . $followingId . "?");

    } if ($following){

        $query = 'DELETE FROM follower WHERE user_id_1 = :user_id_1 AND user_id_2 = :user_id_2';

        $statement = $pdo->prepare($query);
       
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
    
        $statement->bindParam(':user_id_1', $userId, PDO::PARAM_INT);
        $statement->bindParam(':user_id_2', $followingId, PDO::PARAM_INT);
        
        $statement->execute();
    
        redirect("/my-posts.php?user_id=" . $followingId . "?");
    }

}
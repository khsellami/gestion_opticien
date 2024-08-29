<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id_user'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : NULL;
        $login = isset($_POST['login']) ? $_POST['login'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $type_user = isset($_POST['type_user']) ? $_POST['type_user'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE user SET id_user = ?, login = ?, password = ?, type_user = ? WHERE id_user = ?');
        $stmt->execute([$id_user, $login, $password, $type_user, $_GET['id_user']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id_user = ?');
    $stmt->execute([$_GET['id_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<div class="content update">
	<h2>Update User #<?=$user['id_user']?></h2>
    <form action="update.php?id_user=<?=$user['id_user']?>" method="post">
        <label for="id_user">ID_USER</label>
        <label for="login">Login</label>
        <input type="text" name="id_user" placeholder="1" value="<?=$user['id_user']?>" id="id_user">
        <input type="text" name="login"  value="<?=$user['login']?>" id="login">
        <label for="password">Password</label>
        <label for="type_user">Type_user</label>
        <input type="text" name="password"  value="<?=$user['password']?>" id="password">
        <input type="text" name="type_user" value="<?=$user['type_user']?>" id="type_user">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

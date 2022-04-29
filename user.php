<?php
   session_start();
   $user_id = $_SESSION["user_id"] ?? false;
   if($user_id){
       require "vendor/autoload.php";
       $db = new Photos\DB();
       $data = $db->get_user_photos($user_id);
   }
   if (isset($_GET["error"])){
       $error =  "Неверный логин или пароль!";
   }
   if (isset($_GET["sing_error"])){
    $sing_error =  "Товарищ! этот логин ЗАНЯТ прошу придумать другой!";
   }
    if (isset($_GET["sing_success"])){
        $sing_success =  "Регистрация прошла успешно!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

 <?php include "header.php" ?>

    <?php if($user_id): ?>
<h1>Галерея пользователя</h1>
<div id="grid">
     <?php foreach($data as $photo): ?>
     <?=(new Photos\Photo($photo["Id"], $photo["Image"], $photo["Text"]))->get_html()?>
     <?php endforeach; ?>
</div> 

    <?php else: ?> 
     <div class="form">
         <form action="login.php" method="post">
             <h1>Авторизация</h1>
             <input type="text" placeholder="логин" name="login">
             <input type="password" placeholder="Пароль" name="password">
             <button>Вход</button>
             <?php if (isset($_GET["error"])): ?>
               <p class="error"><?= $error ?></p>
              <?php endif ?>
            </form>
    
         <form action="signup.php" method="post">
             <h2>Регистрация</h2>
             <input type="text" placeholder="логин" name="login">
             <input type="password" placeholder="Пароль" name="password">
             <button>Зарегистрироваться</button>
             <?php if (isset($_GET["sing_error"])): ?>
               <p class="error"><?= $sing_error ?></p>
              <?php endif ?>

              <?php if (isset($_GET["sing_success"])): ?>
               <p class="success"><?= $sing_success ?></p>
              <?php endif ?>

            </form>
    </div>
    <?php endif; ?>
    
    <?php include "add_form.php" ?>

    <div id="popup_photo">
        <img src="" alt="">
    </div>
    <script src="script.js"></script>  
</body>
</html>
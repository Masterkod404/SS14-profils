<header>
    <?php
        $patch_file=pathinfo($_SERVER['SCRIPT_NAME']);
        if(!isset($_SESSION['userDB'])){
    ?>
    <div class="cheksMenu">
    <a href="index.php">Авторизация</a>
    <div class="logo_and_h">
        <img src="assets/img/main_logo.png" alt="Лого">
        <h1>Space Online Players 14</h1>
    </div>
    </div>
    <?php
        }else{
    ?>
    <div class="cheksMenu">
        <div class="logo_and_h">
            <img src="assets/img/main_logo.png" alt="Лого">
            <h1>Space Online Players 14</h1>
        </div>
        <a href="index.php">Вернутся на главную</a>    
        <a href="aboutProject.php">О проекте</a>
        <a href="versonList.php">Список версий</a>
        <a href="vendors/components/outlog.php">Выход</a>
    </div>
    <?php
        if($patch_file['basename']!='aboutProject.php' || $patch_file['basename']=='versonList.php'){
    ?>
    <div class="menuPlayer">
        <?php
            if($patch_file['basename']=="index.php"){
        ?>
        <a href="index.php" class="selectedMenu">Основыные данные персонажа</a>
        <?php
            }else{
        ?> 
        <a href="index.php">Основыные данные персонажа</a>
        <?php
            }
            if($patch_file['basename']=="proffesionalPlayer"){
        ?>
        <a href="proffesionalPlayer.php" class="selectedMenu">Профессии</a>
        <?php
            }else{
        ?>
        <a href="proffesionalPlayer.php">Профессии</a>
        <?php
            }
            if($patch_file['basename']=="antagPlayer.php"){
        ?>
        <a href="antagPlayer.php"  class="selectedMenu">Антагонисты</a>
        <?php
            }else{
        ?>
        <a href="antagPlayer.php">Антагонисты</a>
        <?php
            }
            if($patch_file['basename']=="descPlayer.php"){
        ?>
        <a href="descPlayer.php"  class="selectedMenu">Описание</a>
        <?php
            }else{
        ?>
        <a href="descPlayer.php" >Описание</a>
        <?php
            }
        ?>
    </div>
    <?php
            }
        }
    ?>

</header>
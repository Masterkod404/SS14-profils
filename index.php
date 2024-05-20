<?php
    include "vendors/components/core.php";
    if(isset($_POST['login'])){
        $result=$db_ServerSS14->query("SELECT * FROM player WHERE last_seen_user_name='{$_POST['PlayerLogin']}'");
        $resultAssoc=$result->fetchArray(SQLITE3_ASSOC);
        if($result->numColumns()<=0){
            $_SESSION['errors']['loginErrors']="Ошибка, похоже вы ещё не разу ни заходили на наш игровой сервер!";
            header("Location: index.php");
        }else{
            $_SESSION['userDB']['id']=$resultAssoc['user_id'];
            $_SESSION['userDB']['login']=$resultAssoc['last_seen_user_name'];
            $passwordMd=md5($_POST['PlayerPassword']);
            $resultMySql=$db_Server->query("SELECT * FROM `loginProfils` WHERE `Login`='{$_POST['PlayerLogin']}' AND `Password`='{$passwordMd}'");
            if($resultMySql -> num_rows >0){
                $resultMySql=mysqli_fetch_assoc($resultMySql);
                $_SESSION['userMysqli']['id']=$resultMySql['id'];
            }else{
                $_SESSION['errors']['autoRegens']="Неверный логин или пароль, повторите попытку.";
            }
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактор Space Station 14</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<label?php
    
?>
<body>
    <div class="contantMenu">
        <?php

            include "vendors/components/header.php";
            if(!isset($_SESSION['userMysqli']) || isset($_SESSION['errors'])){
                
            if(!isset($_SESSION['errors']['loginErrors'])){
        ?>
            <form action="index.php" method="post" class="absolutContainForm">
                <input type="text" name="PlayerLogin" placeholder="Ваш игровой логин">
                <input type="text" name="PlayerPassword" placeholder="Пароль">
                <button name="login">Авторизоватся</button>
                <a href="">Не связали аккаунт? Не беда, свяжите прямо сейчас!</a>
            </form>

            <?php
                
            }
            if(isset($_SESSION['errors']['loginErrors'])){
            ?>

            <?php
            }
        }
        if(isset($_SESSION['userDB']['login'])){
        ?>
            <div class="absolutContainForm">
            <?php
                $profilsGen=$db_ServerSS14->query("SELECT * FROM profile INNER JOIN preference ON profile.preference_id=preference.preference_id WHERE preference.user_id='D0B8B863-5334-4B76-AA09-734D0263CDF9'");
                // foreach ($profilsGen as $pers => $key) {
                $profils=array();
                while ($res= $profilsGen->fetchArray(1))
                {
                    array_push($profils, $res);
                    
                }   
                $i=0;
                // foreach ($profils as $value) {
                
            ?>
            <div class="rightSelecter">
                <?php
                   foreach ($profils as $value) { 
                    if(!isset($_SESSION['userDB']['SelectedPlay']) && $value['slot']==0){
                ?>
                    <form action="selectPersonal.php" method="post" class="selectForm">
                        <h3>Профиль</h3>
                        <input type="text" name="namePlayer" value="<?=$value['char_name']?>" readonly>
                        <input type="text" name="idPlayer" value="<?=$value['slot']?>" hidden>
                        <button>Выбрать</button>
                    </form>
                <?php
                    }else{ 
                    if(isset($_SESSION['userDB']['SelectedPlay']) && $_SESSION['userDB']['SelectedPlay']==$value['slot']){
                ?>
                    <form action="selectPersonal.php" method="post" class="selectForm">
                        <h3>Профиль</h3>
                        <input type="text" name="namePlayer" value="<?=$value['char_name']?>" readonly>
                        <input type="text" name="idPlayer" value="<?=$value['slot']?>" hidden>
                        <button>Выбрать</button>
                    </form>   
                <?php
                    }else{
                ?>
                  <form action="selectPersonal.php" method="post">
                        <h3>Профиль</h3>
                        <input type="text" name="namePlayer" value="<?=$value['char_name']?>" readonly>
                        <input type="text" name="idPlayer" value="<?=$value['slot']?>" hidden>
                        <button>Выбрать</button>
                    </form> 
                <?php
                    }
                    }
                   }
                ?>
            </div>
            <div class="selectedPlayer">
            <?php
                if(!isset($_SESSION['userDB']['SelectedPlay'])){
                $profilsGen=$db_ServerSS14->query("SELECT * FROM profile INNER JOIN preference ON profile.preference_id=preference.preference_id WHERE preference.user_id='D0B8B863-5334-4B76-AA09-734D0263CDF9' AND profile.slot=0");
                $profils=array();
                while ($res= $profilsGen->fetchArray(1))
                {
                    array_push($profils, $res);
                    
                }
                
            ?>
            <form action="" name="<?='s'.$profils[0]['selected_character_slot'] ?>" >
                <h2 class="hName">Ваше имя</h2>
                <input type="text" name="namePers" value="<?= $profils[0]['char_name']?>">
                <p class="warningName">Внимание: Оскорбительные или странные имена и описания могут повлечь за собой беседу на сервере SS14.
                     Сайт не несёт ответственности за добовляемые данные на сервер, будьте бдительны и соблюдайте правила!</p>

                <label for="race"> Раса
                <?php
                    switch ($profils[0]['species']) {
                        case 'Dwarf':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf' selected>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Reptilian':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian' selected>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Human':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human' selected>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Arachnid':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid' selected>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Diona':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona' selected>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'SlimePerson':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson' selected>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Moth':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth' selected>Моль</option>";
                            echo "</select>";
                            break;
                        default:
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                    }
                ?>
                </label>
                <label for="gender"> Пол
                <?php
                    switch ($profils[0]['gender']) {
                            case 'Male':
                                echo "<select name='gender'>";
                                echo "<option value='Male' selected>Мужчина</option>";
                                echo "<option value='Female'>Женщина</option>";
                                echo "</select>";
                            break;
                            case 'Female':
                                echo "<select name='gender'>";
                                echo "<option value='Male'>Мужчина</option>";
                                echo "<option value='Female' selected>Женщина</option>";
                                echo "</select>";
                            break;
                            default:
                                echo "<select name='gender'>";
                                echo "<option value='Male'>Мужчина</option>";
                                echo "<option value='Female' selected>Женщина</option>";
                                echo "</select>";
                            break;
                    }

                ?>
                </label>
                <h3>Возраст</h3>
                <input type="text" name="age" value="<?=$profils[0]['age']?>">
                <h3>Цвет глаз</h3>
                <input type="range" min="0" max="255" name="rCod" class="rCod" id="rCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('rCod<?=$profils[0]['slot']?>','rCheck<?=$profils[0]['slot']?>')"><input type="text" name="rCheck" class="rCheck" id="rCheck<?=$profils[0]['slot']?>">
                <input type="range" min="0" max="255" name="gCod" class="gCod" id="gCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('gCod<?=$profils[0]['slot']?>','gCheck<?=$profils[0]['slot']?>')"><input type="text" name="gCheck" class="gCheck" id="gCheck<?=$profils[0]['slot']?>">
                <input type="range" min="0" max="255" name="bCod" class="bCod" id="bCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bCod<?=$profils[0]['slot']?>','bCheck<?=$profils[0]['slot']?>')"><input type="text" name="bCheck" class="bCheck" id="bCheck<?=$profils[0]['slot']?>">
                <input type="text" name="hexcod" value="<?= $profils[0]['eye_color'] ?>" class="hexcod" hidden>
                <h3>Цвет кожи</h3>
                <?php
                    if($profils[0]['species']=='Dwarf' || $profils[0]['species']=='Human'){
                ?>
                    <input type="range" min="0" max="255" name="flesh_color" class="flesh_color" id="flesh_color" oninput="ReturnRgb('flesh_color','RGBcodBodyHuman_Dworf')">
                    <input type="text" name="RGBcodBodyHuman_Dworf<?=$profils[0]['slot']?>" class="RGBcodBodyHuman_Dworf" id="RGBcodBodyHuman_Dworf">
                    <input type="text" name="hexcodBodyHuman_Dworf" value="<?= $profils[0]['skin_color'] ?>" class="hexcodBodyHuman_Dworf" hidden>
                <?php
                    }else{
                ?>
                    <input type="range" min="0" max="255" name="bodyrCod" class="bodyrCod" id="bodyrCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodyrCod<?=$profils[0]['slot']?>','bodyrCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodyrCheck" class="bodyrCheck" id="bodyrCheck<?=$profils[0]['slot']?>">
                    <input type="range" min="0" max="255" name="bodygCod" class="bodygCod" id="bodygCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodygCod<?=$profils[0]['slot']?>','bodygCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodygCheck" class="bodygCheck" id="bodygCheck<?=$profils[0]['slot']?>">
                    <input type="range" min="0" max="255" name="bodybCod" class="bodybCod" id="bodybCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodybCod<?=$profils[0]['slot']?>','bodybCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodybCheck" class="bodybCheck" id="bodybCheck<?=$profils[0]['slot']?>">
                    <input type="text" name="hexcodBody" value="<?= $profils[0]['skin_color'] ?>" class="hexcodBody" hidden>
                    
                <?php
                    }
                ?>
                <label for="spawnprioriti"> Приоретет спавна персонажа 
                <?php
                    switch ($profils[0]['spawn_priority']) {
                        case 2:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0>Нет</option>";
                            echo "<option value=2 selected>Крио-капсула</option>";
                            echo "<option value=1>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        case 1:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0>Нет</option>";
                            echo "<option value=2>Крио-капсула</option>";
                            echo "<option value=1 selected>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        default:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0 selected>Нет</option>";
                            echo "<option value=1>Крио-капсула</option>";
                            echo "<option value=2>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        }
                ?>
                </label>
            </form>
            
    <?php     
            $i++;
            }else{
                $profilsGen=$db_ServerSS14->query("SELECT * FROM profile INNER JOIN preference ON profile.preference_id=preference.preference_id WHERE preference.user_id='D0B8B863-5334-4B76-AA09-734D0263CDF9' AND profile.slot='{$_SESSION['userDB']['SelectedPlay']}'");
                $profils=array();
                while ($res= $profilsGen->fetchArray(1))
                {
                    array_push($profils, $res);
                    
                }
                
            ?>
            <form action="" name="<?='s'.$profils[0]['selected_character_slot'] ?>" >
                <h2 class="hName">Ваше имя</h2>
                <input type="text" name="namePers" value="<?= $profils[0]['char_name']?>">
                <p class="warningName">Внимание: Оскорбительные или странные имена и описания могут повлечь за собой беседу на сервере SS14.
                     Сайт не несёт ответственности за добовляемые данные на сервер, будьте бдительны и соблюдайте правила!</p>

                <label for="race"> Раса
                <?php
                    switch ($profils[0]['species']) {
                        case 'Dwarf':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf' selected>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Reptilian':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian' selected>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Human':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human' selected>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Arachnid':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid' selected>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Diona':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona' selected>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'SlimePerson':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson' selected>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                        case 'Moth':
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth' selected>Моль</option>";
                            echo "</select>";
                            break;
                        default:
                            echo "<select name='race'>";
                            echo "<option value='Dwarf'>Дворф</option>";
                            echo "<option value='Reptilian'>Унатх</option>";
                            echo "<option value='Human'>Человек</option>";
                            echo "<option value='Arachnid'>Пауколюд</option>";
                            echo "<option value='Diona'>Диона</option>";
                            echo "<option value='SlimePerson'>Слаймолюд</option>";
                            echo "<option value='Moth'>Моль</option>";
                            echo "</select>";
                            break;
                    }
                ?>
                </label>
                <label for="gender"> Пол
                <?php
                    switch ($profils[0]['gender']) {
                            case 'Male':
                                echo "<select name='gender'>";
                                echo "<option value='Male' selected>Мужчина</option>";
                                echo "<option value='Female'>Женщина</option>";
                                echo "</select>";
                            break;
                            case 'Female':
                                echo "<select name='gender'>";
                                echo "<option value='Male'>Мужчина</option>";
                                echo "<option value='Female' selected>Женщина</option>";
                                echo "</select>";
                            break;
                            default:
                                echo "<select name='gender'>";
                                echo "<option value='Male'>Мужчина</option>";
                                echo "<option value='Female' selected>Женщина</option>";
                                echo "</select>";
                            break;
                    }

                ?>
                </label>
                <h3>Возраст</h3>
                <input type="text" name="age" value="<?=$profils[0]['age']?>">
                <h3>Цвет глаз</h3>
                <input type="range" min="0" max="255" name="rCod" class="rCod" id="rCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('rCod<?=$profils[0]['slot']?>','rCheck<?=$profils[0]['slot']?>')"><input type="text" name="rCheck" class="rCheck" id="rCheck<?=$profils[0]['slot']?>">
                <input type="range" min="0" max="255" name="gCod" class="gCod" id="gCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('gCod<?=$profils[0]['slot']?>','gCheck<?=$profils[0]['slot']?>')"><input type="text" name="gCheck" class="gCheck" id="gCheck<?=$profils[0]['slot']?>">
                <input type="range" min="0" max="255" name="bCod" class="bCod" id="bCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bCod<?=$profils[0]['slot']?>','bCheck<?=$profils[0]['slot']?>')"><input type="text" name="bCheck" class="bCheck" id="bCheck<?=$profils[0]['slot']?>">
                <input type="text" name="hexcod" value="<?= $profils[0]['eye_color'] ?>" class="hexcod" hidden>
                <h3>Цвет кожи</h3>
                <?php
                    if($profils[0]['species']=='Dwarf' || $profils[0]['species']=='Human'){
                ?>
                    <input type="range" min="0" max="255" name="flesh_color" class="flesh_color" id="flesh_color" oninput="ReturnRgb('flesh_color','RGBcodBodyHuman_Dworf')">
                    <input type="text" name="RGBcodBodyHuman_Dworf<?=$profils[0]['slot']?>" class="RGBcodBodyHuman_Dworf" id="RGBcodBodyHuman_Dworf">
                    <input type="text" name="hexcodBodyHuman_Dworf" value="<?= $profils[0]['skin_color'] ?>" class="hexcodBodyHuman_Dworf" hidden>
                    <script src="assets/scripts/HEXFunction.js" type="text/javascript"></script> 
                    <script>
                        hexToRgbBody(hexcodBodyHuman_Dworf.value);
                    </script>
                <?php
                    }else{
                ?>
                    <input type="range" min="0" max="255" name="bodyrCod" class="bodyrCod" id="bodyrCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodyrCod<?=$profils[0]['slot']?>','bodyrCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodyrCheck" class="bodyrCheck" id="bodyrCheck<?=$profils[0]['slot']?>">
                    <input type="range" min="0" max="255" name="bodygCod" class="bodygCod" id="bodygCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodygCod<?=$profils[0]['slot']?>','bodygCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodygCheck" class="bodygCheck" id="bodygCheck<?=$profils[0]['slot']?>">
                    <input type="range" min="0" max="255" name="bodybCod" class="bodybCod" id="bodybCod<?=$profils[0]['slot']?>" oninput="ReturnRgb('bodybCod<?=$profils[0]['slot']?>','bodybCheck<?=$profils[0]['slot']?>')"><input type="text" name="bodybCheck" class="bodybCheck" id="bodybCheck<?=$profils[0]['slot']?>">
                    <input type="text" name="hexcodBody" value="<?= $profils[0]['skin_color'] ?>" class="hexcodBody" hidden>
                    <script src="assets/scripts/HEXFunction.js" type="text/javascript"></script> 
                    <script>
                        for (let index = 0; index < HexCodeBody.length; index++) {
                            hexToRgb(HexCodeBody[index].value,index,false);
                        }
                    </script>
                <?php
                    }
                ?>
                <label for="spawnprioriti"> Приоретет спавна персонажа 
                <?php
                    switch ($profils[0]['spawn_priority']) {
                        case 2:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0>Нет</option>";
                            echo "<option value=2 selectscriptо-капсула</option>";
                            echo "<option value=1>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        case 1:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0>Нет</option>";
                            echo "<option value=2>Крио-капсула</option>";
                            echo "<option value=1 selected>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        default:
                            echo "<select name='spawnprioriti'>";
                            echo "<option value=0 selected>Нет</option>";
                            echo "<option value=1>Крио-капсула</option>";
                            echo "<option value=2>Эвакуационный шаттл</option>";
                            echo "</select>";
                        break;
                        }
                ?>
                </label>
                <button>Сохранить изменения</button>
            </form>

    <?php
            $i++;
            }
        }

    ?>
    <!-- <a href="vendors/components/outlog.php">Выход</a> -->
    </div>
    </div>
</body>
<script src="https://gaidadei.ru/easycanvas/easyc.js"></script>
<script src="assets/scripts/select.js"></script>
<script src="assets/scripts/HEXFunction.js"></script>
</html>
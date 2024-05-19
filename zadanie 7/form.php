<?php

$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$languages = []; 

try {
    $stmt = $db->prepare("SELECT * FROM p_languages;");
    $stmt->execute(); 
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print('Ошибка : ');
    exit();
}
?>

<html lang="ru">

<head>
    <link rel="icon" type="image/x-icon" href="favicon.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Задание 7</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php

if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }


  print('</div>');
}


?>
<?php
if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])){
    echo '
        <div class = "login">
        <form action="" method="POST" >
            <input type="hidden" name="logout" value="true">
            <button type="submit">Выйти</button>
        </form>
        </div>
    ';
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['token'];
}
else 
    echo'
    <div class = "login">
    <form action="login.php" target="_blank">
    <button>Войти</button>
    </form>
    </div>
';
?>
    <div id="forma" class="col-7 my-5">
        <form id="form1" action="" method="POST">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input name="fio" id="name" class="form-control <?php if ($errors['fio']) {print 'is-invalid';} ?>" placeholder="Введите ваше имя"  value="<?php print $values['fio']; ?>">
            </div>
            <div class="form-group">
                <label for="tel">Телефон:</label>
                <input type="tel" name="tel" id="tel"  class="form-control <?php if ($errors['tel']) {print 'is-invalid';} ?>"  placeholder="Введите телефон" value="<?php print $values['tel']; ?>">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>

                <input name="email" type="email" class="form-control <?php if ($errors['email']) {print 'is-invalid';} ?>" id="email" placeholder="Введите вашу почту" value="<?php print $values['email']; ?>">

            </div>
            <div class="form-group">

                Дата рождения:
                <input name="date_of_birth" type="date" class="form-control <?php if ($errors['date_of_birth']) {print 'is-invalid';} ?>" value="<?php print $values['date_of_birth']; ?>" />

            </div>
            <div class="form-group">
                Пол:
                <label for="g1"><input type="radio"  class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g1" value="m" <?php if ($values['gender']=='m') {print 'checked';} ?>>
                    Мужской</label>
                <label for="g2"><input type="radio" class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g2" value="w" <?php if ($values['gender']=='w') {print 'checked';} ?>>
                    Женский</label>
            </div>
            <div class="form-group">
                <label for="mltplslct">Любимые языки программирования:</label>
                <select class="form-control <?php if ($errors['languages']) {print 'is-invalid';} ?>" name="languages[]" id="mltplslct" multiple="multiple">
                <?php foreach ($languages as $language): ?>
            <option value="<?= htmlspecialchars(strip_tags($language['id'])); ?>" 
                <?php if (!empty($values['languages']) && in_array($language['id'], $values['languages'])) {echo 'selected';} ?>>
                <?= htmlspecialchars(strip_tags($language['title'])); ?>
            </option>
        <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?? '' ?>">
            <div class="form-group">
                <label for="bio">Биография:</label>
                <textarea name="bio" id="bio" rows="5" class="form-control <?php if ($errors['bio']) {print 'is-invalid';} ?>" ><?php print $values['bio']; ?></textarea>
            </div>
            <label><input type="checkbox" class="form-check-input <?php if ($errors['checkbox']) {print 'is-invalid';} ?>" id="checkbox" value="1" name="checkbox" <?php if ($values['checkbox']=='1') {print 'checked';} ?>>
                с контрактом ознакомлен (а) </label><br>
            <input type="submit" class="btn btn-primary" value="Отправить">
        </form>
    </div>
</body>
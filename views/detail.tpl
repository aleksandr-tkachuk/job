<!DOCTYPE html>
<html>
    <head>
        <title> Отправка заказа </title>
        <meta charset="utf-8">
        <link href="/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h2>Детальная информация о книге</h2>
        <table>
            <tr>
                <td><?= $row['FIO'] ?></td>
                <td><?= $row['BookName'] ?></td>
                <td><?= $row['BookAbstract'] ?></td>
                <td>цена: <?= $row['BookPrice'] ?> грн.</td>
            </tr>
            <tr>
                <td>наличие: <?= $row['BookNumb'] ?> экз.</td>
                <td>год: <?= $row['BookYear'] ?></td>
                <td>жанр: <?= $row['PublishingName'] ?></td>
                <td>страниц: <?= $row['BookPages'] ?></td>
            </tr>
        </table>

        <h3>Оформить заказ :</h3><br/>
        <form action='detail.php?n=<?=$_GET['n'] ?>' method='post'>
            <span class='user'>
                <label for='firstnamee'>Введите имя : </label>
            </span>
            <input type='text' name='firstname' value='<?=$firstname?>' id='firstnamee' size='40'>
            <?= $firstnameErrText ?>
            <br><br>                
            <span class='user'>
                <label for='lastnamee'>Введите фамилию : </label>
            </span>
            <input type='text' name='lastname'  id='lastnamee' value='<?=$_POST['lastname'] ?>' size='40'>
            <?= $lastnameErrText ?> 
            <br><br>                
            <span class='user'>
                <label for='addresse'>Введите адрес : </label>
            </span>
            <input type='text' name='address' value='<?=$_POST['address']?>' id='addresse' size='40'>
            <?=$addressErrText ?> 
            <br><br>
            <span class='user'>
                <label for='exemplar'>Количество экземпляров : </label>
            </span>
            <input type='number' value='1' min='1' max='100' step='1' name='exemplars' value='<?= $_POST['exemplars'] ?>' id='exemplar' size='40'>
            <?= $exemplarsErrText ?> 
            <br><br>
            <input type='submit'>
            <input type='hidden' name='filled'>
        </form>



        <?php if (isset($_POST["filled"])): ?>
            <?php if (!$sendaddressErr): ?>
                <font color="green"><h1>Спасибо!<br />Ваш заказ оформлен.</h1></font></body></html>';
        <form action = userMain.php method = "post">
            <input type = submit value = "НАЗАД">
        </form>
    <?php else: ?>
        <font color="red">Ваш заказ не оформлен! идите на хуй</font>
    <?php endif ?>
<?php endif ?>
<br><br>
</body>
</html>
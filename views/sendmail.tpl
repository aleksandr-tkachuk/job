<!DOCTYPE html>
<html>
    <head>
        <title> Отправка заказа </title>
        <meta charset="utf-8">
        <link href="/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
<?php if (!$sendaddressErr): ?>
                <font color="green"><h1>Спасибо!<br />Ваш заказ оформлен.</h1></font></body></html>';
        <form action = userMain.php method = "post">
            <input type = submit value = "НАЗАД">
        </form>
    <?php else: ?>
        <font color="red">Ваш заказ не оформлен! идите на хуй</font>
    <?php endif ?>
    </body>
</html>
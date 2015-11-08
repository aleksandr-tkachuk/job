<?php
require_once 'models/booksModel.php';

class DetailsController {
    
    private $params;


    public function __construct($params) {
        $this->params = $params;
    }
    
    function booksAction(){
        
    }

    function detailAction() {
        $booksModel = new BooksModel();
        $row = $booksModel->getDetails($this->params[0]);


        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';


        $firstnameErrText = "";
        $lastnameErrText = "";
        $addressErrText = "";
        $exemplarsErrText = "";
        if (isset($_POST["filled"])) {

            if (empty($_POST['firstname'])) {
                $firstnameErrText = "не ввели имя!";
            }

            if (empty($_POST['lastname'])) {
                $lastnameErrText = "<span class=err> не ввели фамилию! </span> ";
            }

            if (empty($_POST['address'])) {
                $addressErrText = "<span class=err> не ввели адрес! </span> ";
            }
            if (empty($_POST['exemplars'])) {
                $exemplarsErrText = "<span class=err> не выбрано количество! </span> ";
            }


            if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['address']) && !empty($_POST['exemplars'])) {
                $body = $row['FIO'] . "\r\n" . $row['BookName'] . ", количество: " . $_POST["exemplars"] . "\r\n" . $_POST["firstname"] . " " .
                        $_POST["lastname"] . " " . $_POST["address"];
                $title = substr(htmlspecialchars(trim($_POST['lastname'])), 0, 1000) . " ";
                $title .= substr(htmlspecialchars(trim($_POST['firstname'])), 0, 1000) . ", ";
                $title .="Адресс :" . substr(htmlspecialchars(trim($_POST['address'])), 0, 1000);
                $to = 'admin@test.ru';
                $sendaddress = mail($to, $title, 'Заказ:' . $body);

                $mailer = new Mailer();
                try {
                    $mailer->send($to, $title, 'Заказ:' . $body);
                } catch (Exception $err) {
                    $sendaddressErr = true;
                }
            }
        }

        include_once 'views/detail.tpl';
    }

}

<?php

abstract class AbstractModel implements GeneralModel{

    public function __construct() {
        @$db = mysql_connect("localhost", "root", "123456") or die("Ошибка при соединении к базе");
        @$er = mysql_select_db("bookshop") or die("Ошибка в выборе базы");
        mysql_query("SET NAMES utf8");
    }
}

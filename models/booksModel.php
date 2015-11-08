<?php

require_once 'intarfaces/generalModel.php';
require 'models/abstractModel.php';

class BooksModel extends AbstractModel {

    public function add(array $data) {
        
    }

    public function getAll() {
        
    }

    public function getById($id) {
        
    }

    public function update($id, array $data) {
        
    }

    public function delete($id) {
        
    }

    public function getDetails($id) {
        $id = (int)$id;
        $query = "SELECT BookName,BookAbstract,BookPrice,BookNumb,BookYear,BookPages,FIO,PublishingName 
	FROM books,authors,publishings WHERE BookID='$id'";
        $result = mysql_query($query);
        if (mysql_num_rows($result) < 1) {
            throw new Exception("Книга с заданным идентификатором не найдена!");
        }
        $row = mysql_fetch_array($result);
        return $row;
    }

}

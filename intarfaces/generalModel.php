<?php

interface GeneralModel {
    function getById($id);
    function getAll();
    function update($id, array $data);
    function add(array $data);
}
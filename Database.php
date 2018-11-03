<?php

class Database extends SQLite3{
    
    function __construct(){
        $this->open('categories.db');
        $this->exec('CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(30), parent_id INTEGER)');
    }

    /**
     * @param $category - pridedama kategorija
     */
    function addCategory($category){
        $name = $category->name;
        $parent_id = $category->parent_id;
        
        $query = "INSERT INTO categories (name, parent_id) VALUES ('$name', $parent_id)";
        $this->exec($query);
    }

    /**
     * @param $id - grazinamos kategorijos id
     * @return Category
     */
    function getCategory($id){
        $query = "SELECT * FROM categories WHERE id = $id";
        $result = $this->query($query);

        $result = $result->fetchArray();
        return new Category($result['id'], $result['name'], $result['parent_id']);
    }

    /**
     * @return array - visu kategoriju masyvas
     */
    function getAllCategories(){
        $categories = array();
       $query = "SELECT * FROM categories";
       $result = $this->query($query);
       while($row = $result->fetchArray()){
           $categories [] = new Category($row['id'], $row['name'], $row['parent_id']);
       }
       return $categories;
    }

    /**
     * @param $id - tevo, kurio vaikai ieskomi id
     * @return array - vaiku kategoriju masyvas
     */
    function getChildCategories($id){
        $categories = array();
        $query = "SELECT * FROM categories WHERE parent_id = $id ";
        $result = $this->query($query);
        while($row = $result->fetchArray()){
            $categories[] = new Category($row['id'], $row['name'], $row['parent_id']);
        }
        return $categories;
    }

    /**
     * @param $category - kategorija, kurios tevas ieskomas
     * @return Category - $category kategorijos tevas
     */
    function getParentCategory($category){
        $query = "SELECT * FROM categories WHERE id = $category->parent_id";
        $result = $this->query($query);
        $result = $result->fetchArray();
        return new Category($result['id'], $result['name'], $result['parent_id']);
    }
}
?>

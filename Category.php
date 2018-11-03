<?php

class Category{
    
    public $id;
    public $name;
    public $parent_id;

    
    function __construct($id = 0, $name, $parent_id){
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
    }
    
    function printChildren($level){
        $childCategories = $GLOBALS['database']->getChildCategories($this->id);
        foreach ($childCategories as $child) {
           echo "</br>".str_repeat("-", $level).'|'.$child->name;
           $child->printChildren($level + 1);   
        }       
    }
    
    function getPath(){
        $path="";
        for($category = $this; $category->parent_id != 0; $category = $GLOBALS['database']->getCategory($category->parent_id)){
            $path = $category->name.'/'.$path;
        }
        $path = $category->name.'/'.$path;
        return $path;
        
    }
    
    function printChildrenIterative(){
        $stack = new Stack();
    }
}
?>


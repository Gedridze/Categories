<?php

class Category{
    
    public $id;
    public $name;
    public $parent_id; //kategorijos tevo id
    public $level;  // kategorijos gylis medyje

    
    function __construct($id = 0, $name, $parent_id){
        $this->id = $id;
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->depth = $this->depth();
    }


    /**
     * @return int - kategorijos gylis
     */
    function depth(){
        $depth = 0;
        $category = $this;
        while($category->parent_id != 0){
            $depth++;
            $category = $GLOBALS['database']->getParentCategory($category);
        }
        return $depth;
    }

    /**
     * kategoriju spausdinimas rekursiniu budu
     */
    function printChildrenRecursive($level){
        $childCategories = $GLOBALS['database']->getChildCategories($this->id);
        foreach ($childCategories as $child) {
           echo "</br>".str_repeat("-", $level).'|'.$child->name;
           $child->printChildrenRecursive($level + 1);
        }       
    }

    /**
     * @return string - pilnas kategorijos kelias
     */
    function getPath(){
        $path="";
        for($category = $this; $category->parent_id != 0; $category = $GLOBALS['database']->getCategory($category->parent_id)){
            $path = $category->name.'/'.$path;
        }
        $path = $category->name.'/'.$path;
        return $path;
        
    }


    /**
     * kategoriju spausdinimas iteraciniu budu
     */
    function printChildrenIterative(){
        $stack = array();
        array_push($stack, $this);
        while(count($stack) != 0){
            $topCategory = array_pop($stack);
            foreach($GLOBALS['database']->getChildCategories($topCategory->id) as $child){

                array_push($stack, $child);
            }
            echo "</br>".str_repeat("-", $topCategory->depth).'|'.$topCategory->name;
        }
    }
}
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php 
              include 'Database.php';
              $GLOBALS['database'] = new Database();
              include 'Category.php';
              if ($_POST != null){
                  $database->addCategory(new Category(null, $_POST['category'], $_POST['parent']));
              }
              $categories = $database->getAllCategories();
        ?>
        <form action="index.php" method="post">
            <label for="category">Įveskite kategoriją: </label>
            <input type="text" name="category">
            <br>
            <label for="parent">Pasirinkite kategorijos tėvą (parent category)</label>
            <select name="parent">
                <option value="0">/</option>
                <?php
                foreach ($categories as $category) {
                    
                    echo '<option value='.$category->id.'>/'.$category->getPath().'</option>';
                }
                ?>
            </select>
            <br>
            <button type="submit">Pridėti</button>
        </form>
        </br>
        <div style='font-family: Consolas, monaco, monospace;'>
        <?php  $rootCategories = $database->getChildCategories(0);
            foreach ($rootCategories as $category) {
                echo $category->name;
                $category->printChildren(1);
        }?>
        </div>
    </body>
</html>

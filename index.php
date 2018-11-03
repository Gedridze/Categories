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
        <style>
            div {
                width:50%;
                display: inline-block;
            }
            .form-content {
                padding: 15px;
            }
            .categories{
                font-family: Consolas, monaco, monospace;
                width: auto;
                text-align: justify;
            }
            form{
                border-bottom: 1px solid;
                padding-bottom: 5px;
            }
        </style>

    </head>
    <body style="text-align: center">
        <?php 
              include 'Database.php';
              $GLOBALS['database'] = new Database();
              include 'Category.php';
              if (isset($_POST['category'])){
                  $database->addCategory(new Category(null, $_POST['category'], $_POST['parent']));
              }
              $categories = $database->getAllCategories();
        ?>
        <br style="width: 50%; display: inline-block">
        <form action="index.php" method="post">
            <div class="form-content">
                <label for="category">Įveskite kategoriją: </label>
                <input type="text" name="category">
            </div>
            <br>
            <div class="form-content">
                <label for="parent">Pasirinkite kategorijos tėvą (parent category)</label>
                <select name="parent">
                    <option value="0">/</option>
                    <?php
                    foreach ($categories as $category) {
                    
                        echo '<option value='.$category->id.'>/'.$category->getPath().'</option>';
                    }
                    ?>
                </select>
            </div>
            <br>
            <button type="submit">Pridėti</button>
        </form>

        </br>
        <div class="categories">
        <?php  $rootCategories = $database->getChildCategories(0);
            foreach ($rootCategories as $category) {
                if(!isset($_POST['printType']) || $_POST['printType'] == 'recursive'){
                    echo "</br>".str_repeat("-", 0).'|'.$category->name;
                    $category->printChildrenRecursive(1);
                }
                else if ($_POST['printType'] == 'iterative'){
                    $category->printChildrenIterative();
                }
        }?>
        </div>
        </br>
        <div class="form-content">
            <form action="index.php" method="post">
                <label for="printTypeForm">Pasirinkite kategorijų spausdinimo būdą: </label>
                <div name="printTypeForm">
                    <input type="radio" name="printType" value="recursive">Rekursinis
                    <input type="radio" name="printType" value="iterative">Iteracinis
                </div>
                <button type="submit">Spausdinti</button>
            </form>
        </div>
    </body>
</html>

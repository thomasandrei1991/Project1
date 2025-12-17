<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style2.css">
        <title>Document</title>
    </head>
    <body>
        <div class="container">
            <div class="fruitbox">
                <h2>
                    <?php
                        echo "Fruits Lists" . "<br>";
                    ?>
                </h2>
                <p>
                    <?php
                        fruitList();
                    ?>
                </p>
            </div>
            <div class="vegetablebox">
                <h2>
                    <?php
                        echo "Vegetables Lists" . "<br>";
                    ?>
                </h2>
                <p>
                    <?php
                        vegetableList();
                    ?>
                </p>
            </div>
        </div>
    </body>
</html>
<?php
    function fruitList(){
        $fruits = array ("Apple", "Banana", "Cucomber", "Grapes", "Strawberry");
        foreach ($fruits as $fruit){
            echo "* $fruit <br>";
        }
    }
    function vegetableList(){
        $vegetables = array ("Malungay", "Carrot", "Spinach", "Ginger", "Onion");
        foreach ($vegetables as $vegetable){
            echo "* $vegetable <br>";
        }
    }
?>
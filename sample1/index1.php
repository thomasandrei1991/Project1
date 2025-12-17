<?php
    $showForm = false;

    // kapag clinic yung button:
    if (isset($_POST['show_form'])) {
        $showForm = true;        
    }
?>
<?php
    $hideForm = true;

    // kapag clinic yung button:
    if (isset($_POST['hide_form'])) {
        $showForm = false;
    }
?>
<?php
    $showFile = false;

    // kapag clinic yung button:
    if (isset($_POST['show_file'])) {
        $showFile = true;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Show Form Example</title>
    </head>
    <body>
        <!-- BUTTON -->
        <form method="post">
            <button type="submit" name="show_form">Show Form</button>
        </form>
        <br><br>
        <form method="post">
            <button type="submit" name="hide_form">Hide Form</button>
        </form>
        <br><br>
        <form method="post">
            <button type="submit" name="show_file">Show File</button>
        </form>
        <hr>
        <!-- CONDITIONAL FORM -->
        <?php if ($showForm): ?>
            <form method="post" action="submit.php">
                <label>Name:</label>
                <input type="text" name="name"><br><br>

                <label>Email:</label>
                <input type="email" name="email"><br><br>

                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>
        <?php if ($hideForm): ?>
            <h1>The form is hide</h1>
        <?php endif; ?>
        <?php 
            if ($showFile){
                 include 'index.html';
                 $showForm = false;
                 $hideForm = false;
                 
            }
        ?>
    </body>
</html>

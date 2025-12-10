<?php
    $showForm = false;

    // kapag clinic yung button:
    if (isset($_POST['show_form'])) {
        $showForm = true;
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
    </body>
</html>

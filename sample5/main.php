<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="main_style.css">
        <title>Sample 5</title>
    </head>
    <body>
        <main>
            <section>
                <h1 id="title">Language Theory</h1>
                <div class="container">
                    <div class="card" id="csharp">
                        <h1>C#</h1>
                        <p>Programming Language</p>
                        <form action="csharp.php" method="post">
                            <button id="btn-csharp" name="csharp">View</button>
                        </form>
                    </div>
                    <div class="card" id="python">
                        <h1>Python</h1>
                        <p>Programming Language</p>
                        <form action="python.php" method="post">
                            <button id="btn-python" name="python">View</button>
                        </form>
                    </div>
                    <div class="card" id="cpp">
                        <h1>C++</h1>
                        <p>Programming Language</p>
                        <form action="cpp.php" method="post">
                            <button id="btn-cpp" name="cpp">View</button>
                        </form>
                    </div>
                    <div class="card" id="java">
                        <h1>Java</h1>
                        <p>Programming Language</p>
                        <form action="java.php" method="post">
                            <button id="btn-java" name="java">View</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
<?php
    if(isset($_POST['csharp'])){
        header("Location: csharp.php");
    }
    else if(isset($_POST['python'])){
        header("Location: python.php");
    }
    else if(isset($_POST['cpp'])){
        header("Location: cpp.php");
    }
    else if(isset($_POST['java'])){
        header("Location: java.php");
    }
?>
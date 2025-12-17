<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            body{
                background-color: black;
                font-family: Arial, Helvetica, sans-serif;
            }
            h1{
                text-align: center;
                color: purple;
            }
            p{
                color: purple;
                font-size: 30px;
            }
            .box1{
                margin-top: 100px;
                max-width: 900px;
                border-color: gold;
                border-style: solid;
                border-radius: 20px;
                border-width: 10px;
                background-color: transparent;
                padding: 30px;
            }
            .container{
                margin-top: 100px;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                gap: 5px;
            }
            .header-container h1{
                margin: 30px;
            }
        </style>
    </head>
    <body>
        <div class="header-container">
             <h1>Box Model</h1>
        </div>
        <div class="container">
            <div class="box1">
                <h1>This is a sample text</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit blanditiis ducimus id dicta architecto! Ipsum voluptatum consequatur omnis impedit corporis deserunt dignissimos, optio eius temporibus id quasi, culpa quod autem!</p>
            </div> 
            <div class="box1">
                <h1>This is a sample text</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit blanditiis ducimus id dicta architecto! Ipsum voluptatum consequatur omnis impedit corporis deserunt dignissimos, optio eius temporibus id quasi, culpa quod autem!</p>
            </div>
            <div class="box1">
                <h1>This is a sample text</h1>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit blanditiis ducimus id dicta architecto! Ipsum voluptatum consequatur omnis impedit corporis deserunt dignissimos, optio eius temporibus id quasi, culpa quod autem!</p>
            </div>
        </div>
    </body>
</html>
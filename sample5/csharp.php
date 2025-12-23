<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="csharp_style.css">
        <title>Document</title>
    </head>
    <body>
        <header>
            <h1>Introduction to C#</h1>
            <hr>
        </header>
        <main>
            <section>
                <div class="fundamentals">
                    <p id="p1">Fundamentals of C#</p>
                    <p id="p2">
                        C# (pronounced C-Sharp) is a modern, object-oriented programming language developed by Microsoft. It is commonly used to create desktop applications, web applications, mobile apps, games (using Unity), and enterprise software. C# runs on the .NET framework, which provides a rich set of libraries and tools for efficient development.
                    </p>
                </div>
            </section>
            <section>
                <div class="basic-structure">
                    <p id="p3">Basic Structure of C#</p>
                    <p id="p4">
                        A simple C# program consists of namespaces, classes, and methods. The Main() method is the entry point where program execution begins.
                    </p>
                    <p><br>
                        using System; <br>
                        class Program <br>
                        {<br>
                            &nbsp;static void Main() <br>
                            &nbsp;{<br>
                                &nbsp;&nbsp;Console.WriteLine("Hello, World!");<br>
                            &nbsp;}<br>
                        }<br>
                    </p>
                </div>
            </section>
            <section>
                 <div class="variables-data-types">
                    <p id="p3">Variables and Data Types in C#</p>
                    <p id="p4">
                        Variables store data that can be used and modified in a program. C# is a strongly-typed language, meaning each variable must have a defined data type.
                    </p>
                    <p id="p5">Common data types:</p><br>
                    <ul>
                        <li>int – whole numbers</li>
                        <li>double – decimal numbers</li>
                        <li>float – smaller decimal numbers</li>
                        <li>char – single character</li>
                        <li>string – text</li>
                        <li>bool – true or false</li>   
                    </ul><br><br>
                    <p id="p6">Example : <br><br>
                        for (int i = 1; i <= 5; i++) <br>
                        {<br>
                        &nbsp;&nbsp;Console.WriteLine(i);<br>
                        }<br>
                    </p>
                </div>
            </section>
            <section>
                 <div class="input-output">
                    <p id="p7">Input and Output in C#</p>
                    <p id="p8">
                        C# uses the Console class to interact with users.
                    </p>
                    <p id="p9">Example : <br><br>
                        Console.Write("Enter your name: "); <br>
                        string name = Console.ReadLine(); <br>
                        Console.WriteLine("Hello " + name); <br>
                    </p>
                </div>
            </section>
        </main>
    </body>
</html>

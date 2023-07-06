<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Livease</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        .container h1{
            font-family: 'figtree', sans-serif;
            font-weight: 400;
            font-size: 3rem;
            color: #333;
        }
        .container p{
            font-family: 'figtree', sans-serif;
            font-weight: 600;
            font-size: 1.5rem;
            color: #333;
        }
        .content{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container">
        <div class="content">
        <h1>Livease</h1>
        <p>Something good is brewing</p>        
    </div>
    
    </div>
</body>

</html>
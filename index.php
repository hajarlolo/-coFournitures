<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>ÉcoFournitures 📚</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: rgb(255, 254, 244);
        }

        .header {
            top: 10%;
            width: 97.6%;
            padding: 20px;
            height: 100vh;
            background-image: url('photo.jpeg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-bottom-right-radius: 5%;
            border-bottom-left-radius: 5%;
            border-bottom: 2px solid #B29688;
        }

        .top-menu {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .top-menu a {
            text-align: center;
            width: 20%;
            text-decoration: none;
            background-color: #B29688;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .top-menu a:hover {
            background-color: rgb(158, 122, 105);
            transform: scale(1.05);
        }

        .top-menu a:active {
            background-color: rgb(143, 112, 96);
            transform: scale(0.97);
        }

        .container {
            width: 55%;
            height: 10%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
            padding: 20px;
            border: 1px solid rgb(135, 106, 92);
            border-radius: 40px;
            background-color: rgba(245, 241, 232, 0.52);
            color: rgb(91, 65, 53);
        }


        footer {
            background-color: transparent;
            color: #B29688;
            text-align: center;
            padding: 8px;
            font-size: 1 em;

        }
    </style>
</head>

<body>

    <div class="header">
        <div class="top-menu">
            <a href="login.php">Sign in / Sign up</a>
        </div>
        <div class="container">
            <h1 class="slogan">Donner une seconde vie aux fournitures scolaires </h1>
        </div>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> ÉcoFournitures. Tous droits réservés. | Contact : contact@ecofournitures.org</p>
    </footer>

</body>

</html>
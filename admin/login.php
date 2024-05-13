<?php
session_start();
require_once __DIR__ . "/../dbConnect.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE-edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Axel Schwindenhammer - Admin - Login</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body class="flex flex-col fullscreen">
        <header>
            <nav class="navbar">
                <img
                    src="../assets/icons/dev.png"
                    alt="logo developpeur web axel schwindenhammer"
                    class="navbar navbar__logo"
                />
                <h1>
                  Admin-Login
                </h1>
                <div class="navbar navbar__linkBlock">
                    <a class="navbar navbar__link" href="../">A Propos</a>
                    <a class="navbar navbar__link" href="../#work">Mon Travail</a>
                    <a class="navbar navbar__link" href="../#contact">Contact</a>
                </div>
            </nav>
        </header>
        <div class="modalBox__background">
          <div class="modalBox flex flex-row">
          <?php if (!isset($_SESSION["LOGGED_USER"])): ?>
            <div class="modalBox__element">
              <img src="../assets/icons/dev.png" alt="">
            </div>
            <div class="modalBox__element">
              <form action="login_submit.php" method="post">
                <div>
                  <label for="login">Login</label>
                  <br/>
                  <input class="input" type="text" name="login">
                </div>
                <div>
                  <label for="password">Passsword</label>
                  <br/>
                  <input class="input" type="password" name="password">
                </div>
                <div>
                  <button class="btn" type="submit">Valider</button>
                </div>
              </form>
              <form action="login_submit.php" method="post">
                <input class="input" type="hidden" name="login" value="invite">
                <input class="input" type="hidden" name="password" value="invite">
                <div>
                  <button class="btn" type="submit">Connexion invité</button>
                </div>
              </form>
            </div>
          <?php else: ?>
          <div>
            <h1>Utilisateur connecté :<?php echo $_SESSION["LOGGED_USER"][
              "pseudo"
            ]; ?></h1>
            <form action="login_submit.php" method="post">
              <input type="hidden" name="logout"/>
              <button class="btn" type="submit">Déconnection</button>
            </form>
          </div>
          <?php endif; ?>
          </div>
        </div>

</body>
</html>

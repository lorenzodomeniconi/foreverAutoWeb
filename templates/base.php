<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="style/icons/foreverAuto.ico">
        <link rel="stylesheet" href="style/css/regole.css">
        <title><?php echo $templateParams['title']; ?></title>
    </head>
    <body>
    <main>
        <header id="header">
            <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a class="navbar-brand" href="index.php">
                        <img src="style/forever.png" alt="Logo" style="height: 50px;">
                    </a>
                    
                    <!-- Bottone hamburger per mobile -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Menu di navigazione -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <?php if(isUserLoggedIn()): ?>
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link <?php echo isActive("index.php");?>" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-nav-link <?php echo isActive("notifies.php");?>" href="notifies.php">Notifiche</a>
                            </li>
                            <?php if($_SESSION["ruolo"] === Roles::BUYER->value): ?>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav-link <?php echo isActive("cart.php");?>" href="cart.php">Carrello</a>
                                    </li>
                            <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if(isUserLoggedIn()): ?>
                                <li class="nav-item d-lg-none">
                                    <a class="nav-link custom-nav-link profile-link" href="profile.php">
                                        <?php if($_SESSION["ruolo"] === Roles::BUYER->value): ?>
                                            <?php echo htmlspecialchars($_SESSION["nome"]); ?>
                                        <?php elseif($_SESSION["ruolo"] === Roles::DEALER->value): ?>
                                            <?php echo htmlspecialchars($_SESSION["ragSociale"]); ?>
                                        <?php endif; ?>
                                    </a>
                                </li>

                                <li class="nav-item d-lg-none">                                
                                    <a class="nav-link custom-nav-link logout-link" href="logout.php">Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item d-lg-none">
                                    <a class="nav-link custom-nav-link" href="login.php" >Login</a>
                                </li>
                                <li class="nav-item d-lg-none">
                                    <a class="nav-link custom-nav-link" href="signup.php" >Registrati</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <div class="d-none d-lg-flex ms-auto">
                        <?php if(isUserLoggedIn()): ?>
                            <a class="nav-link custom-nav-link profile-link" href="profile.php">
                                    <?php if($_SESSION["ruolo"] === Roles::BUYER->value): ?>
                                        <?php echo htmlspecialchars($_SESSION["nome"]); ?>
                                    <?php elseif($_SESSION["ruolo"] === Roles::DEALER->value): ?>
                                        <?php echo htmlspecialchars($_SESSION["ragSociale"]); ?>
                                    <?php endif; ?>
                                </a>
                            <a class="nav-link custom-nav-link logout-link" href="logout.php">Logout</a>
                        <?php endif; ?>

                        <?php if(!isUserLoggedIn()): ?>
                            <a class="nav-link custom-nav-link" href="login.php">Login</a>
                            <a class="nav-link custom-nav-link" href="signup.php">Registrati</a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </header>

        <?php
            if(isset($templateParams['name'])) require($templateParams['name']);
        ?>
    </main>
        
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1">&copy; 2025 Forever Auto - Tutti i diritti riservati</p>
            <div class="mb-2">
                <a href="#" class="text-decoration-none">
                    <i class="bi bi-facebook social-icon me-5"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="bi bi-instagram social-icon me-5"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="bi bi-twitter-x social-icon me-5"></i>
                </a>
                <a href="#" class="text-decoration-none">
                    <i class="bi bi-youtube social-icon"></i>
                </a>
            </div>

            <div>
                <a href="#" class="text-white me-3 text-decoration-none">Privacy</a>
                <a href="#" class="text-white me-3 text-decoration-none">Termini</a>
                <a href="#" class="text-white text-decoration-none">Contatti</a>
            </div>
        </div>
    </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
</html>
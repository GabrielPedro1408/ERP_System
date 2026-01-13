<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neo Gestão - Login</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js"></script>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/all.css">
</head>
<body>
    <!-- Background Animation -->
    <div class="background-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="./assets/images/financeiro.png" alt="logo"></a>
                <span>Neo Gestão</span>
            </div>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Voltar ao Site
            </a>
        </div>
    </header>
        <?php
            if (isset($_SESSION['message'])):
                $type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';
        ?>
                <div class="alert alert-<?= $type ?> alert-dismissible fade show alert-top-fixed" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            endif;
        ?>
    <!-- Main Container -->
    <div class="main-container">
        
        <div class="login-container centered">
            <!-- Login Form -->
            <div class="form-container sign-in centered-form">
                <form action="../app/Controllers/LoginController.php" method="POST" autocomplete="on" class="login-form">
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h1>Login</h1>
                        <span>Informe suas credenciais para acessar o sistema</span>
                    </div>

                    <div class="input-group">
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" id="username" placeholder="Usuário" required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Senha" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div class="error-message" id="errorMessage" style="display: none;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Nome de usuário ou senha incorretos!</span>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Lembrar de mim
                        </label>
                        <a href="https://wa.me/5511987670128?text=Olá, esqueci a senha, pode me ajudar? " class="forgot-password">Esqueceu a senha?</a>
                    </div>

                    <button type="submit" name="entrar" class="btn-login">
                        <span>Entrar</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <span>Carregando...</span>
        </div>
    </div>

    <script src="./assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
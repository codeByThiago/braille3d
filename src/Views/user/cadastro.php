<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <title>Braille3D - Login</title>
</head>
<body>
    <?php include VIEWS . "includes/alert.php";?>
    <div id="main-content-wrapper">
        <section class="auth">
            <div id="welcome-content">
                <img src="assets/img/logo-braille3d.png" class="logo-icon" alt="Logo Braille3D">
                <div>
                    <p>Seja bem vindo á tela de</p>
                    <h1>Cadastro</h1>
                    <p>Realize seu login para deixar modelos de placa salvos!</p>
                </div>
            </div>
            <div class="form-auth-content">
                <form action="" method="post" id="auth-form">
                    <h2>Braille3D</h2>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <label for="nome" class="sr-only">Nome:</label>
                        <input type="text" name="nome" id="nome" autocomplete="username" required placeholder="Digite seu nome">
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <label for="email" class="sr-only">Email:</label>
                        <input type="email" name="email" id="email" autocomplete="email" required placeholder="Digite seu email">
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <label for="senha" class="sr-only">Senha:</label>
                        <input type="password" name="senha" id="senha" autocomplete="new-password" required placeholder="Digite sua senha" min="8">
                        <button type="button" class="eye-password-viewer-btn" id="mostra-senha-btn">
                            <i class="fa-solid fa-eye" id='eye-senha'></i>
                        </button>
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <label for="confirme-senha" class="sr-only">Confirme a senha:</label>
                        <input type="password" name="confirme-senha" id="confirme-senha" autocomplete="new-password" required placeholder="Confirme sua senha" min="8">
                        <button type="button" class="eye-password-viewer-btn" id="mostra-confirme-senha-btn">
                            <i class="fa-solid fa-eye" id='eye-confirme-senha'></i>
                        </button>
                    </div>
                    <button type="submit" class="auth-submit-btn">Registrar</button>
                    <p>Já possui cadastro? <a href="/login">Faça Login</a></p>
                </form>
            </div>
        </section>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php';?>
    <script src="filtros.js"></script>
    <script type="module" src="senha.js"></script>
</body>
</html>
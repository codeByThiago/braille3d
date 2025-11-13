<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <script src="filtros.js"></script>
    <title>Braille3D - Login</title>
</head>
<body>
    <div id="main-content-wrapper">
        <?php include VIEWS . "includes/alert.php";?>
        <section class="auth">
            <div id="welcome-content">
                <img src="assets/img/logo-braille3d.png" class="logo-icon" alt="Logo Braille3D">
                <div>
                    <p>Seja bem vindo á tela de</p>
                    <h1>Login</h1>
                    <p>Realize seu login para deixar modelos de placa salvos!</p>
                </div>
            </div>
            <div class="form-auth-content">
                <form action="" method="post" id="auth-form">
                    <h2>Braille3D</h2>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <label for="email" class="sr-only">Email:</label>
                        <input type="email" name="email" id="email" autocomplete="email" required placeholder="Digite seu email">
                    </div>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-key"></i>
                        <label for="senha" class="sr-only">Senha:</label>
                        <input type="password" name="senha" id="senha" autocomplete="current-password" required placeholder="Digite sua senha" min="8">
                        <button type="button" class="eye-password-viewer-btn" id="mostra-senha-btn">
                            <i class="fa-solid fa-eye" id='eye-senha'></i>
                        </button>
                    </div>
                    <div class="input-group">
                        <input type="checkbox" name="remind-me" id="remind-me">
                        <label for="remind-me">Lembrar-me neste dispositivo</label>
                    </div>
                    <button type="submit" class="auth-submit-btn">Entrar</button>
                    <p>Esqueceu a senha? <a href="/user/esqueci-a-senha">Clique aqui.</a></p>
                    <p>Não possui cadastro? <a href="/cadastro">Cadastre-se</a></p>
                        <a href="/user/google-login" class="google-btn"><i class="fa-brands fa-google"></i> Entrar com Google</a>
                </form>
            </div>
        </section>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php';?>
    <script type="module" src="senha.js"></script>
</body>
</html>
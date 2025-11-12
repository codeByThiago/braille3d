<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <title>Braille3D - Redefinir Senha</title>
</head>
<body>
    <?php include VIEWS . "includes/alert.php"; ?>
    
    <div id="main-content-wrapper">
        <section class="auth">
            <div id="welcome-content">
                <img src="/assets/img/logo-braille3d.png" class="logo-icon" alt="Logo Braille3D">
                <div>
                    <h1>Redefinir Senha</h1>
                    <p style="color:#aaa; font-size:0.9rem; margin-top:5px;">
                        Insira e confirme sua nova senha abaixo.
                    </p>
                </div>
            </div>

            <div class="form-auth-content">
                <form action="" method="post" id="auth-form">
                    <h2>Nova Senha</h2>

                    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <label for="nova_senha" class="sr-only">Nova senha:</label>
                        <input 
                            type="password" 
                            name="nova_senha" 
                            id="nova_senha" 
                            autocomplete="new-password" 
                            required 
                            placeholder="Digite sua nova senha"
                            minlength="8"
                        >
                        <button type="button" class="eye-password-viewer-btn" id="mostra-senha-btn">
                            <i class="fa-solid fa-eye" id="eye-senha"></i>
                        </button>
                    </div>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <label for="confirmar_senha" class="sr-only">Confirmar senha:</label>
                        <input 
                            type="password" 
                            name="confirmar_senha" 
                            id="confirmar_senha" 
                            autocomplete="new-password" 
                            required 
                            placeholder="Confirme sua nova senha"
                            minlength="8"
                        >
                        <button type="button" class="eye-password-viewer-btn" id="mostra-confirma-btn">
                            <i class="fa-solid fa-eye" id="eye-confirma"></i>
                        </button>
                    </div>

                    <button type="submit" class="auth-submit-btn">Redefinir Senha</button>
                </form>
            </div>
        </section>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php'; ?>
    <script src="/assets/js/filtros.js"></script>
    <script type="module" src="/assets/js/senha.js"></script>
</body>
</html>

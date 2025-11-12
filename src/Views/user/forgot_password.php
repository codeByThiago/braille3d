<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <title>Braille3D - Esqueci minha senha</title>
</head>
<body>
    <?php include VIEWS . "includes/alert.php"; ?>

    <div id="main-content-wrapper">
        <section class="auth">
            <div id="welcome-content">
                <img src="/assets/img/logo-braille3d.png" class="logo-icon" alt="Logo Braille3D">
                <div>
                    <h1>Esqueci minha senha</h1>
                    <p style="color:#aaa; font-size:0.9rem; margin-top:5px;">
                        Digite o e-mail cadastrado e enviaremos um link para redefinição.
                    </p>
                </div>
            </div>

            <div class="form-auth-content">
                <form action="" method="post" id="auth-form">
                    <h2>Redefinir Senha</h2>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <label for="email" class="sr-only">E-mail:</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            placeholder="Digite seu e-mail"
                            required
                        >
                    </div>

                    <button type="submit" class="auth-submit-btn">Enviar Link</button>
                </form>
            </div>
        </section>
    </div>

    <?php include VIEWS . 'includes/filtros-cor.php'; ?>
    <script src="/filtros.js"></script>
</body>
</html>

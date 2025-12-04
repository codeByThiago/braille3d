<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/404.css">
    <script src="/filtros.js"></script>
    <title>Braille3D - Not Found Error 404</title>
</head>
<body>
    <main id="main-content-wrapper">
        <?php include VIEWS . "includes/alert.php";?>

        <section class="error-container">
            <div class="error-content">
                <h1 class="error-code">404</h1>
                <h2 class="error-message">Página Não Encontrada</h2>
                <p class="error-description">
                    Parece que a página que você está procurando não existe ou foi movida.
                    Não se preocupe, isso acontece!
                </p>
                <a href="/" class="back-home-btn">
                    <i class="fas fa-home"></i> Voltar para a Página Inicial
                </a>
                <p class="error-tip">
                    Se você digitou o endereço, verifique a ortografia.
                </p>
            </div>
            <div class="braille-container">
                <div class="braille-visual">
                    <span class="dot"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                </div>
                <div class="braille-visual">
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
                <div class="braille-visual">
                    <span class="dot"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
                <div class="braille-visual">
                    <span class="dot dot-active"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot dot-active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </section>
    </main>

    
    <?php include VIEWS . "includes/filtros-cor.php";?>
    <script src="/perfil.js"></script>
</body>
</html>
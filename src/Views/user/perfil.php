<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/412e60f1e0.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/historico_perfil.css">
    <script src="filtros.js"></script>
    <title>Braille3D - Perfil</title>
</head>
<body>
    <main id="main-content-wrapper">
        <?php include VIEWS . "includes/navbar.php";?>
        <?php include VIEWS . "includes/alert.php";?>

        <div id="overlay-edicao" class="edit-overlay hidden">
            <div class="edit-popup">
                <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>

                <!-- FORMULÁRIO 1: ALTERAR NOME -->
                <form method="POST" class="edit-popup-form" action="/perfil/atualizar-nome">
                    <label for="nome">Nome:</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= $usuario['name'] ?? '' ?>"
                        required
                    >
                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                        <i class="fas fa-save"></i> Salvar Nome
                        </button>
                        <button type="button" id="cancelar-edicao" class="cancel-btn">
                        <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>

                <!-- FORMULÁRIO 2: ALTERAR EMAIL -->
                <form method="POST" class="edit-popup-form" action="/perfil/atualizar-email">
                    <label for="email">E-mail:</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= $usuario['email'] ?? '' ?>"
                        required
                    >
                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                        <i class="fas fa-envelope"></i> Enviar E-mail de Verificação
                        </button>
                        <button type="button" id="cancelar-edicao" class="cancel-btn">
                        <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>

                <!-- FORMULÁRIO 3: SOLICITAR TROCA DE SENHA -->
                <form method="POST" class="edit-popup-form" action="/perfil/solicitar-troca-senha">
                    <label for="senha">Alterar Senha:</label>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        Clique abaixo para receber um e-mail de redefinição de senha.
                    </p>
                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                        <i class="fas fa-envelope"></i> Enviar E-mail de Redefinição
                        </button>
                        <button type="button" id="cancelar-edicao" class="cancel-btn">
                        <i class="fas fa-times"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="profile-page-container">
            <!-- ===== SIDEBAR ===== -->
            <aside class="profile-sidebar">
                <div class="profile-user-info">
                    <div class="profile-picture-wrapper">
                        <img 
                            src="
                            <?php
                                if($usuario['google_id'] == NULL) {
                                    echo !empty($usuario['picture']) ? '../assets/img/uploads/' . htmlspecialchars($usuario['picture']) : '../assets/img/default-user.jpg';
                                } else {
                                    echo 'assets/img/uploads/' . $usuario['picture'];
                                }
                            ?>" 
                            alt="Foto de Perfil" 
                            class="profile-picture"
                        >
                        <i class="fas fa-camera profile-edit-icon"></i>

                        <!-- input escondido -->
                        <form id="form-foto" enctype="multipart/form-data" method="POST" style="display: none;">
                            <input type="file" name="foto_perfil" id="foto-perfil-input" accept="image/*">
                        </form>
                    </div>
                    
                    <h2 class="profile-display-name"><?php echo $usuario['name'] ?? 'Nome do Usuário'; ?></h2>
                    <p class="profile-display-email"><?php echo $usuario['email'] ?? 'email@exemplo.com'; ?></p>
                    
                    <button class="profile-action-btn edit-profile-btn">
                        <i class="fas fa-user-edit"></i> Editar Perfil
                    </button>
                </div>

                <nav class="profile-side-menu">
                    <h3 class="menu-title">Navegação</h3>
                    
                    <a href="#" class="profile-menu-item active">
                        <i class="fas fa-user"></i> Meu Perfil
                    </a>
                    <a href="/ajuda" class="profile-menu-item">
                        <i class="fas fa-question-circle"></i> Ajuda
                    </a>
                    <a href="logout" class="profile-menu-item logout">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </nav>
            </aside>

            <!-- ===== CONTEÚDO PRINCIPAL ===== -->
            <section class="profile-main-content">
                <h1 class="content-main-title"><i class="fas fa-user"></i> Informações do Perfil</h1>

                <!-- INFORMAÇÕES DO PERFIL -->
                <div class="boards-grid">

                    <!-- Card: Dados Pessoais -->
                    <div class="board-item-card status-success">
                        <div class="card-header">
                            <span class="card-board-title">Dados Pessoais</span>
                        </div>
                        <div class="card-details">
                            <p><i class="fas fa-user"></i> Nome: <strong><?php echo $usuario['name'] ?? 'Thiago Rodrigues'; ?></strong></p>
                            <p><i class="fas fa-envelope"></i> Email: <strong><?php echo $usuario['email'] ?? 'thiago@email.com'; ?></strong></p>
                            <p><i class="fas fa-calendar-alt"></i> Membro desde: <strong><?= date("d/m/Y", strtotime($usuario["created_at"])); ?></strong></p>
                        </div>
                        <div class="card-actions">
                            <button class="action-btn-primary"><i class="fas fa-edit"></i> Editar</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include VIEWS . "includes/footer.php";?>
    </main>

    
    <?php include VIEWS . "includes/filtros-cor.php";?>
    <script src="perfil.js"></script>
</body>
</html>
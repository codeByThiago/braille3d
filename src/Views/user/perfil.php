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

        <div id="overlay-edicao" class="edit-overlay hidden">
            <div class="edit-popup">
                <h2><i class="fas fa-user-edit"></i> Editar Perfil</h2>
                <form method="POST" class="edit-popup-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?= $usuario['name'] ?? '' ?>">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= $usuario['email'] ?? '' ?>">

                <label for="senha">Nova Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Deixe em branco para não alterar">

                <div class="form-actions">
                    <button type="submit" class="save-btn">
                    <i class="fas fa-save"></i> Salvar Alterações
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
                            src="<?php echo !empty($usuario['picture']) ? '../assets/img/uploads/' . htmlspecialchars($usuario['picture']) : '../assets/img/default-user.jpg'; ?>" 
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
                    <a href="#" class="profile-menu-item">
                        <i class="fas fa-question-circle"></i> Ajuda
                    </a>
                    <a href="logout.php" class="profile-menu-item logout">
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
    <script>
        const editIcon = document.querySelector('.profile-edit-icon');
        const fotoInput = document.getElementById('foto-perfil-input');
        const formFoto = document.getElementById('form-foto');

        // Ao clicar no ícone, abre o input file
        editIcon.addEventListener('click', () => {
            fotoInput.click();
        });

        // Ao selecionar o arquivo, envia o form automaticamente
        fotoInput.addEventListener('change', () => {
            if(fotoInput.files.length > 0) {
                const formData = new FormData();
                formData.append('foto_perfil', fotoInput.files[0]);

                fetch('/perfil', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Atualiza a imagem no perfil sem recarregar a página
                        document.querySelector('.profile-avatar').src = data.filePath + '?t=' + new Date().getTime();
                        document.querySelector('.profile-picture').src = data.filePath + '?t=' + new Date().getTime();
                        // alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro ao atualizar a foto!');
                });
            }
        });
    </script>
</body>
</html>
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
    <title>Braille3D - Histórico de Placas</title>
</head>
<body>
    <main id="main-content-wrapper">
        <?php include VIEWS . "includes/navbar.php"; ?>

        <?php
        // === CONFIGURAÇÕES ===
        $itensPorPagina = 6;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

        // === FILTRA AS PLACAS ===
        $placasFiltradas = [];

        $placas = array_reverse($placas);

        if (!empty($busca)) {
            foreach ($placas as $placa) {
                if (stripos($placa['texto'], $busca) !== false) {
                    $placasFiltradas[] = $placa;
                }
            }
        } else {
            $placasFiltradas = $placas;
        }

        // === PAGINAÇÃO ===
        $totalPlacas = count($placasFiltradas);
        $totalPaginas = ceil($totalPlacas / $itensPorPagina);
        if ($paginaAtual < 1) $paginaAtual = 1;
        if ($paginaAtual > $totalPaginas) $paginaAtual = $totalPaginas;

        $inicio = ($paginaAtual - 1) * $itensPorPagina;
        $placasPagina = array_slice($placasFiltradas, $inicio, $itensPorPagina);
        ?>

        <div class="profile-page-container">
            <section class="profile-main-content">
                <h1 class="content-main-title"><i class="fas fa-history"></i> Histórico de Placas Braille 3D</h1>

                <!-- === CAMPO DE BUSCA FUNCIONAL === -->
                <div class="history-filters">
                    <form method="GET" action="">
                        <input 
                            type="text" 
                            name="busca" 
                            placeholder="Buscar por texto da placa..." 
                            class="filter-input"
                            value="<?= htmlspecialchars($busca) ?>"
                        >
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <div class="boards-grid">
                    <?php foreach ($placasPagina as $placa): ?>
                        <div class="board-item-card status-success">
                            <div class="card-header">
                                <span class="card-board-title">
                                    <?= htmlspecialchars($placa["texto"]) ?: "Placa sem nome"; ?>
                                </span>
                            </div>

                            <div class="card-details">
                                <p><i class="fas fa-calendar-alt"></i> <strong>Criada em:</strong>
                                    <?= date("d/m/Y", strtotime($placa["created_at"])); ?>
                                </p>
                                <p><i class="fas fa-ruler-combined"></i> <strong>Tamanho da Forma:</strong>
                                    <?= htmlspecialchars($placa["tam_forma"]); ?>
                                </p>
                                <p><i class="fas fa-layer-group"></i> <strong>Espessura:</strong>
                                    <?= htmlspecialchars($placa["espessura"]); ?>
                                </p>
                            </div>

                            <div class="card-actions">
                                <button class="action-btn-secondary">
                                    <a href="/?id=<?= $placa['id'] ?>&texto=<?= urlencode($placa['texto']) ?>&uppercase=<?= $placa['uppercase'] ? 1 : 0 ?>&contracoes=<?= $placa['contracoes'] ?>&conversao_direta=<?= $placa['conversao_direta'] ? 1 : 0 ?>&tam_forma=<?= $placa['tam_forma'] ?>&altura_ponto=<?= $placa['altura_ponto'] ?>&diametro_ponto=<?= $placa['diametro_ponto'] ?>&espessura=<?= $placa['espessura'] ?>&margem=<?= $placa['margem'] ?>&canto_referencia=<?= $placa['canto_referencia'] ? 1 : 0 ?>&suporte=<?= $placa['suporte'] ? 1 : 0 ?>" style="color: inherit; text-decoration: none;">
                                        <i class="fas fa-eye"></i> Visualizar 3D
                                    </a>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($placasPagina)): ?>
                        <div class="board-item-card status-pending">
                            <div class="card-header">
                                <span class="card-board-title">Nenhuma placa encontrada</span>
                            </div>
                            <div class="card-details">
                                <p><i class="fas fa-info-circle"></i> Nenhuma placa corresponde à sua busca.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- === PAGINAÇÃO FUNCIONAL COM FILTRO === -->
                <div class="history-pagination">
                    <?php if ($paginaAtual > 1): ?>
                        <a href="?pagina=<?= $paginaAtual - 1 ?>&busca=<?= urlencode($busca) ?>" class="page-nav-btn">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </a>
                    <?php else: ?>
                        <button class="page-nav-btn disabled" disabled>
                            <i class="fas fa-chevron-left"></i> Anterior
                        </button>
                    <?php endif; ?>

                    <span class="page-indicator">
                        Página <?= $paginaAtual ?> de <?= max($totalPaginas, 1) ?>
                    </span>

                    <?php if ($paginaAtual < $totalPaginas): ?>
                        <a href="?pagina=<?= $paginaAtual + 1 ?>&busca=<?= urlencode($busca) ?>" class="page-nav-btn">
                            Próximo <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="page-nav-btn disabled" disabled>
                            Próximo <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <?php include VIEWS . "includes/footer.php"; ?>
    </main>
    <?php include VIEWS . "includes/filtros-cor.php"; ?>
</body>
</html>

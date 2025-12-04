
<?php

use DAOs\UserDAO;

if(isset($_SESSION['user_id'])) {
    $userDAO = new UserDAO;
    $usuario = $userDAO->selectById($_SESSION['user_id']);
}

?>

<header class="navbar-header">
    <nav class="navbar-container">
        
        <a href="/" class="navbar-logo-link">
            <img src="../assets/img/logo-braille3d.png" alt="Logo Braille3d" class="navbar-logo">
            <span class="navbar-brand-name">Braille3d</span>
        </a>

        <button class="menu-toggle" aria-controls="navbar-menu" aria-expanded="false" aria-label="Abrir menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <div class="navbar-menu" id="navbar-menu">
            <ul class="navbar-links">

                <?php if (!(isset($_SESSION['logado']) && $_SESSION['logado'] === true)): ?>
                    <li class="nav-item">
                        <a href="/login" class="nav-link login-button">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="/cadastro" class="nav-link cad-button">Cadastro</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mobile-only">
                            <a href="/perfil" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Perfil
                        </a>
                    </li>
                        <li class="nav-item">
                        <a href="/historico" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Histórico de Placas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/logout" class="nav-link logout-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Sair da conta
                        </a>
                    </li>
                    <li class="nav-item profile-desktop">
                        <a href="/perfil" class="profile-avatar-link">
                            <img 
                            src="<?php
                                if($usuario['google_id'] == NULL) {
                                    echo !empty($usuario['picture']) ? '../assets/img/uploads/' . htmlspecialchars($usuario['picture']) : '../assets/img/default-user.jpg';
                                } else {
                                    echo 'assets/img/uploads/' . $usuario['picture'];
                                }
                            ?>" 
                            alt="Foto de Perfil" 
                            class="profile-avatar"
                        >
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item theme-switch-container">
                    <button id="theme-toggle" class="theme-toggle" aria-label="Trocar tema">
                        <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                        <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</header>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.querySelector('.menu-toggle');
            const navbarMenu = document.querySelector('.navbar-menu');
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            // 1. Toggle do Menu Mobile
            menuToggle.addEventListener('click', () => {
                const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
                menuToggle.setAttribute('aria-expanded', !isExpanded);
                navbarMenu.classList.toggle('active');
            });

            // 2. Toggle do Tema (Claro/Escuro)
            themeToggle.addEventListener('click', () => {
                if (html.getAttribute('data-theme') === 'dark') {
                    html.setAttribute('data-theme', 'light');
                    // Salvar a preferência do usuário (ex: localStorage)
                    localStorage.setItem('theme', 'light');
                } else {
                    html.setAttribute('data-theme', 'dark');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // Inicializar o tema
            const savedTheme = localStorage.getItem('theme') || 'dark'; // Padrão é dark
            html.setAttribute('data-theme', savedTheme);
        });
    </script>
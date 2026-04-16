<?php
if (!isset($pageTitle) || trim((string) $pageTitle) === '') {
    $pageTitle = 'AstroByte';
}

if (!isset($activePage)) {
    $activePage = 'inicio';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="icon" type="image/png" href="images/logo.png?v=1">
    <link rel="shortcut icon" type="image/png" href="images/logo.png?v=1">
    <link rel="apple-touch-icon" href="images/logo.png?v=1">
</head>
<body>
    <header class="header">
        <!-- Botón hamburguesa -->
        <button id="hamburgerBtn" class="hamburger" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <a href="index.php" class="logo">
            <img src="images/logo.png?v=1" alt="Logo AstroByte" class="logo-img">
            <span>AstroByte</span>
        </a>

        <!-- Navegación tradicional (visible en PC) -->
        <nav>
            <a href="index.php" class="<?php echo $activePage === 'inicio' ? 'active' : ''; ?>">𝐈𝐧𝐢𝐜𝐨</a>
            <a href="productos.php" class="<?php echo $activePage === 'productos' ? 'active' : ''; ?>">𝐏𝐫𝐨𝐝𝐮𝐜𝐭𝐨𝐬</a>
            <a href="contacto.php" class="<?php echo $activePage === 'contacto' ? 'active' : ''; ?>">𝐂𝐨𝐧𝐭𝐚𝐜𝐭𝐨</a>
        </nav>
    </header>

    <!-- Panel lateral izquierdo (menú hamburguesa) -->
    <div id="sidePanel" class="side-panel">
        <div class="side-panel-header">
            <h3>Menú</h3>
            <button id="closePanelBtn" class="close-panel">&times;</button>
        </div>
        <div class="side-panel-body">
            <!-- 1. BUSCADOR (arriba de todo) -->
            <form id="searchForm" action="productos.php" method="GET">
                <input type="text" name="buscar" id="searchInput" placeholder="Ej: Teclado, Mouse, Auriculares..." autocomplete="off">
                <button type="submit" class="search-submit">Buscar</button>
            </form>

            <!-- 2. BANNER (debajo del buscador) -->
            <img src="images/banner-menu.jpg" alt="Banner del menú" class="menu-banner">

            <!-- 3. ENLACES DE NAVEGACIÓN (abajo del todo) -->
            <div class="panel-nav">
                <a href="index.php" class="<?php echo $activePage === 'inicio' ? 'active' : ''; ?>">Inicio</a>
                <a href="productos.php" class="<?php echo $activePage === 'productos' ? 'active' : ''; ?>">Productos</a>
                <a href="contacto.php" class="<?php echo $activePage === 'contacto' ? 'active' : ''; ?>">Contacto</a>
            </div>
        </div>
    </div>

    <!-- Overlay para cerrar el panel -->
    <div id="panelOverlay" class="panel-overlay"></div>

    <script>
    (function() {
        const hamburger = document.getElementById('hamburgerBtn');
        const panel = document.getElementById('sidePanel');
        const overlay = document.getElementById('panelOverlay');
        const closeBtn = document.getElementById('closePanelBtn');

        function openPanel() {
            panel.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePanel() {
            panel.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (hamburger) hamburger.addEventListener('click', openPanel);
        if (closeBtn) closeBtn.addEventListener('click', closePanel);
        if (overlay) overlay.addEventListener('click', closePanel);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && panel.classList.contains('active')) {
                closePanel();
            }
        });
    })();
    </script>
<?php
$pageTitle = 'AstroByte | Productos';
$activePage = 'productos';
include 'header.php';

// Capturar término de búsqueda desde la URL
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
?>

<link rel="stylesheet" href="css/estilos.css">

<main>
    <section class="products-hero reveal">
        <img src="images/banner6.jpg" alt="Banner de productos" class="products-banner">
    </section>

    <section class="preview reveal">
        <h2>ᴛᴏᴅᴏꜱ ʟᴏꜱ ᴘʀᴏᴅᴜᴄᴛᴏꜱ</h2>
        <p class="intro">Actualizamos stock constantemente para que compres con confianza...</p>

        <?php if ($buscar !== ''): ?>
            <div class="search-info" id="searchInfo">
                Mostrando resultados para: <strong><?php echo htmlspecialchars($buscar); ?></strong>
                <a href="productos.php" class="clear-search">✖ Limpiar búsqueda</a>
            </div>
        <?php endif; ?>

        <div class="product-grid" id="productGrid">
            <?php
            $productos = include __DIR__ . '/productos-data.php';
            $contador = 0;
            foreach ($productos as $i => $p) {
                $img = htmlspecialchars($p["img"], ENT_QUOTES, "UTF-8");
                $nombre = htmlspecialchars($p["nombre"], ENT_QUOTES, "UTF-8");
                $desc = htmlspecialchars($p["desc"], ENT_QUOTES, "UTF-8");
                $tag = htmlspecialchars($p["tag"] ?? "", ENT_QUOTES, "UTF-8");
                $link = htmlspecialchars($p["link"], ENT_QUOTES, "UTF-8");

                // ✅ CORREGIDO: mostrar tag si existe, sin límite de índice
                $mostrarTag = !empty($tag);

                // Si hay búsqueda, verificar coincidencia (en nombre o descripción)
                $coincide = true;
                if ($buscar !== '') {
                    $buscarLower = mb_strtolower($buscar, 'UTF-8');
                    $nombreLower = mb_strtolower($nombre, 'UTF-8');
                    $descLower = mb_strtolower($desc, 'UTF-8');
                    $coincide = strpos($nombreLower, $buscarLower) !== false || strpos($descLower, $buscarLower) !== false;
                }

                if ($coincide) {
                    $contador++;
                    echo '<article class="product-card reveal">';
                    if ($mostrarTag) {
                        echo '<span class="tag">' . $tag . '</span>';
                    }
                    echo '<img src="' . $img . '" alt="' . $nombre . '" loading="lazy">';
                    echo '<h3>' . $nombre . '</h3>';
                    echo '<p>' . $desc . '</p>';
                    echo '<a target="_blank" rel="noopener noreferrer sponsored nofollow" href="' . $link . '" class="buy-btn">Ver en Mercado Libre</a>';
                    echo '</article>';
                }
            }
            ?>
        </div>

        <?php if ($buscar !== '' && $contador === 0): ?>
            <div class="no-results">
                No se encontraron productos para "<strong><?php echo htmlspecialchars($buscar); ?></strong>". Probá con otra palabra.
            </div>
        <?php endif; ?>
    </section>
</main>

<script>
(function () {
    var items = document.querySelectorAll('.reveal');

    function checkVisibility() {
        items.forEach(function (el) {
            if (el.classList.contains('show')) return;
            var rect = el.getBoundingClientRect();
            var windowHeight = window.innerHeight || document.documentElement.clientHeight;
            if (rect.top < windowHeight - 50 && rect.bottom > 0) {
                el.classList.add('show');
            }
        });
    }

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        items.forEach(function (el) { observer.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('show'); });
    }

    window.addEventListener('load', checkVisibility);
    window.addEventListener('resize', checkVisibility);
})();
</script>

<?php include 'footer.php'; ?>
<?php include 'header.php'; ?>

<link rel="stylesheet" href="css/estilos.css">

<main>
    <!-- Banner 1 -->
    <section class="hero reveal">
        <img src="images/banner.jpg" alt="Banner principal" class="banner banner-main">
        <h1>AstroByte</h1>
        <p>Descubre gadgets, periféricos y tecnología que vale la pena comprar</p>

        <div class="hero-actions">
            <a href="productos.php" class="btn">CATALOGO</a>
            <a href="contacto.php" class="btn btn-secondary">Contactanos</a>
        </div>

        <!-- Banner 2 -->
        <img src="images/banner2.jpg" alt="Segundo banner" class="banner banner-second">
    </section>

    <section class="preview reveal">
        <h2>ᴘʀᴏᴅᴜᴄᴛᴏꜱ ᴅᴇꜱᴛᴀᴄᴀᴅᴏꜱ</h2>
        <div class="product-grid">
            <?php
            $productos = include __DIR__ . '/productos-data.php';
            $productosDestacados = array_slice($productos, 0, 6);

            foreach ($productosDestacados as $p) {
                $img = htmlspecialchars($p["img"], ENT_QUOTES, "UTF-8");
                $nombre = htmlspecialchars($p["nombre"], ENT_QUOTES, "UTF-8");
                $desc = htmlspecialchars($p["desc"], ENT_QUOTES, "UTF-8");
                $tag = htmlspecialchars($p["tag"] ?? "", ENT_QUOTES, "UTF-8");
                $link = htmlspecialchars($p["link"], ENT_QUOTES, "UTF-8");

                echo '<article class="product-card reveal">';
                if (!empty($tag)) {
                    echo '<span class="tag">' . $tag . '</span>';
                }
                echo '<img src="' . $img . '" alt="' . $nombre . '" loading="lazy">';
                echo '<h3>' . $nombre . '</h3>';
                echo '<p>' . $desc . '</p>';
                echo '<a target="_blank" rel="noopener noreferrer sponsored nofollow" href="' . $link . '" class="buy-btn">Ver en Mercado Libre</a>';
                echo '</article>';
            }
            ?>
        </div>
    </section>

    <!-- Botón "Ver todos los productos" con margen -60px -->
    <div style="text-align: center; margin: -60px auto 30px;">
        <a href="productos.php" class="btn">¡Ver todos los productos!</a>
    </div>

    <!-- Banner 3 -->
    <section class="mid-banner reveal">
        <img src="images/banner3.jpg" alt="Banner de productos actualizados" class="info-banner">
    </section>

    <section class="extra-content reveal">
        <h3>ꜱᴏʙʀᴇ ᴀꜱᴛʀᴏʙʏᴛᴇ</h3>
        <p>AstroByte es tu fuente confiable para descubrir gadgets y productos tecnológicos de calidad. Desde periféricos gaming hasta componentes de alto rendimiento, nuestro objetivo es ayudarte a encontrar los mejores productos en un solo lugar.</p>

        <h3>ɢᴜɪᴀꜱ ʏ ʀᴇᴄᴏᴍᴇɴᴅᴀᴄɪᴏɴᴇꜱ</h3>
        <p>Nos enfocamos en productos que realmente valen la pena. Cada recomendación se basa en análisis, reseñas y experiencia de usuarios. Encontrarás productos que mejoran tu experiencia tecnológica sin perder tiempo buscando en múltiples sitios.</p>

        <h3>ᴘʀᴏᴅᴜᴄᴛᴏꜱ ꜱɪᴇᴍᴘʀᴇ ᴀᴄᴛᴜᴀʟɪᴢᴀᴅᴏꜱ</h3>
        <p>En tecnología, los precios y modelos cambian constantemente. Mantener productos actualizados es clave para encontrar mejores oportunidades, evitar publicaciones antiguas y elegir equipos compatibles con las necesidades actuales.</p>
        <p>Por eso, en AstroByte priorizamos recomendaciones vigentes: versiones nuevas, opciones con mejor relación precio/rendimiento y alternativas que realmente valgan la pena hoy.</p>

        <!-- Banner 4 -->
        <img src="images/banner4.jpg" alt="Banner adicional AstroByte" class="info-banner">
    </section>

    <div class="footer-text reveal">
        <p>&copy; <?php echo date('Y'); ?> AstroByte. Todos los derechos reservados.</p>
        <p>
            AstroByte es un sitio informativo especializado en recomendaciones de tecnologia.
            Las marcas, nombres comerciales, imagenes y precios publicados pertenecen a sus
            respectivos titulares y pueden cambiar sin previo aviso. Algunos enlaces pueden ser
            enlaces de afiliado, sin costo adicional para el usuario.
        </p>
    </div>
</main>

<script>
(function() {
    var isMobile = window.innerWidth <= 768;

    if (isMobile) {
        // En móvil: mostrar todos los .reveal inmediatamente
        var items = document.querySelectorAll('.reveal');
        for (var i = 0; i < items.length; i++) {
            items[i].classList.add('show');
        }
    } else {
        // En PC: usar IntersectionObserver para efecto scroll
        var items = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            items.forEach(function(el) {
                observer.observe(el);
            });
        } else {
            // Fallback: mostrar todos si no soporta observer
            for (var i = 0; i < items.length; i++) {
                items[i].classList.add('show');
            }
        }
    }
})();
</script>

<?php include 'footer.php'; ?>
<main class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>

    <?php include 'iconos.php' ?>
</main>

<section class="seccion contenedor">
    <h2>Casas y Departamentos en Venta</h2>

    <?php 
        include 'listado.php';
    ?>

    <div class="alinear-derecha">
        <a href="/propiedades" class="boton-verde">Ver Todas</a>
    </div>
</section>

<section class="imagen-contacto">
    <h2>Encuentra la Casa de tus Sueños</h2>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto, id similique?</p>
    <a href="/contacto" class="boton-amarillo">Contáctanos</a>
</section>

<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h3>Nuestro Blog</h3>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jepg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Entrada blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Terraza en el Techo de tu Casa</h4>

                    <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

                    <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero</p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jepg">
                    <img loading="lazy" src="build/img/blog2.jpg" alt="Entrada blog">
                </picture>
            </div>

            <div class="texto-entrada">
                <a href="entrada.html">
                    <h4>Guía para la Decoración de tu Casa</h4>

                    <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

                    <p>Maximiza el espacio de tu hogar con esta guía, aprendos, tips y consejos para que tu hogar sea lo más destacado posible</p>
                </a>
            </div>
        </article>
    </section>

    <section class="testimoniales">
        <h3>Testimoniales</h3>

        <div class="testimonial">
            <blockquote>
                El personal de la empresa fue muy amable, cercano y atento en todo momento. Gracias por brindarnos un servicio de excelencia.
            </blockquote>
            <p>- Rodrigo Cruz</p>
        </div>
    </section>
</div>
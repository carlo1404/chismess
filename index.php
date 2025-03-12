<?php require_once 'includes/header.php';?>
<?php require_once 'includes/barra.php';?>

<!-- CAJA PRINCIPAL -->
<div id="principal">
                <h1>Últimas entradas</h1>
                <article class="entrada">
                    <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2>{Titulo Entrada}</h2>
                        <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                        <p>
                            {Descripcion de entrada}
                        </p>
                    </a>
                </article>
                
                <article class="entrada">
                    <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2>{Titulo Entrada}</h2>
                        <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                        <p>
                            {Descripcion de entrada}
                        </p>
                    </a>
                </article>
                
                <article class="entrada">
                    <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2>{Titulo Entrada}</h2>
                        <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                        <p>
                            {Descripcion de entrada}
                        </p>
                    </a>
                </article>
                
                <article class="entrada">
                    <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2>{Titulo Entrada}</h2>
                        <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                        <p>
                            {Descripcion de entrada}
                        </p>
                    </a>
                </article>
                
                <article class="entrada">
                    <a href="entrada.php?id=<?=$entrada['id']?>">
                        <h2>{Titulo Entrada}</h2>
                        <span class="fecha">{Categoria} | {Fecha de publicación}</span>
                        <p>
                            {Descripcion de entrada}
                        </p>
                    </a>
                </article>
                
                <div id="ver-todas">
                    <a href="entradas.php">Ver todas las entradas</a>
                </div>
            </div> <!--fin principal-->
            
        </div> <!-- fin contenedor -->
<?php require_once 'includes/footer.php';?>
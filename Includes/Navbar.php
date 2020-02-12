<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">Sync Up SEO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link">Usuario: <?php echo "<b>" . $_SESSION["USER_NAME"] . "</b>"; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>
<ul class="nav navbuttons">
    <?php foreach (get_categorias() as $categoria) { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= site_url("{$this->session->userdata('pais')['ISO']}/{$categoria['slug']}") ?>"><?= $categoria['icon'] ?> <?= $categoria['nombre'] ?></a>
        </li>
    <?php } ?>
</ul>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>Tienda Emprendedores</title>
        <link><?= site_url($ciudad); ?></link>
        <description>Compra en la tienda de los emprendedores</description>
        <?php foreach ($productos as $pos => $producto) { ?>
            <item>
                <g:id><?= $producto['id_producto'] ?></g:id>
                <g:title><?= ucwords(mb_strtolower($producto['producto'])) ?></g:title>
                <g:description><?= ucfirst(mb_strtolower(str_replace('&','y',$producto['descripcion']))) ?></g:description>
                <g:link><?= site_url($ciudad) ?></g:link>
                <g:image_link><?= base_url('assets/tienda/' . $producto['imagen']) ?></g:image_link>
                <g:brand><?= ucwords(mb_strtolower(str_replace('&','y',$producto['emprendimiento']))) ?></g:brand>
                <g:condition>new</g:condition>
                <g:availability>in stock</g:availability>
                <g:price><?= $producto['precio'] ?> COP</g:price>
                <g:custom_label_0><?= $producto['categoria'] ?></g:custom_label_0>
                <g:custom_label_1><?= $producto['ciudad'] ?></g:custom_label_1>
            </item>
        <?php } ?>
    </channel>
</rss>
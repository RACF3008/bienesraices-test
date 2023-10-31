<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título de la Propiedad" value="<?php echo sane($propiedad->titulo); ?>"/>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" placeholder="Precio de la Propiedad" name="propiedad[precio]" value="<?php echo sane($propiedad->precio); ?>"/>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png"/>

    <?php if($propiedad->imagen) : ?>
        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripicón:</label>
    <textarea id="descripcion" name="propiedad[descripcion]"><?php echo sane($propiedad->descripcion); ?></textarea>
</fieldset>

<fieldset>
    <legend>Información Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="13" value="<?php echo sane($propiedad->habitaciones); ?>"/>

    <label for="wc">Baños:</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 1" min="1" max="13" value="<?php echo sane($propiedad->wc); ?>"/>

    <label for="estacionamientos">Estacionamientos:</label>
    <input type="number" id="estacionamientos" name="propiedad[estacionamiento]" placeholder="Ej: 1" min="1" max="13" value="<?php echo sane($propiedad->estacionamiento); ?>"/>
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    
    <label for="vendedor">Vendedor:</label>
    <select name="propiedad[vendedores_id]" id="vendedor">
        <option value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor): ?>
            <option <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?> value="<?php echo sane($vendedor->id); ?>">
                <?php echo sane($vendedor->nombre);?> <?php echo ' '; ?> <?php echo sane($vendedor->apellido); ?>
            </option>
        <?php endforeach; ?>
    </select>
</fieldset>
<?= $header ?>

<div class="container mt-4">
    <h3>Editar Usuario</h3>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('usuarios/actualizar/'.$usuario['idusuario']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="nomuser" class="form-label">Usuario</label>
            <input type="text" name="nomuser" id="nomuser" class="form-control"
                   value="<?= old('nomuser', $usuario['nomuser']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="passuser" class="form-label">Contraseña (dejar en blanco si no cambia)</label>
            <input type="password" name="passuser" id="passuser" class="form-control">
        </div>

        <div class="mb-3">
            <label for="idpersona" class="form-label">Persona</label>
            <select name="idpersona" id="idpersona" class="form-select" required>
                <option value="">-- Seleccionar --</option>
                <?php foreach($personas as $p): ?>
                    <option value="<?= $p['idpersona'] ?>"
                        <?= old('idpersona', $usuario['idpersona']) == $p['idpersona'] ? 'selected' : '' ?>>
                        <?= $p['nombres'] . ' ' . $p['apepaterno'] . ' ' . $p['apematerno'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="idrol" class="form-label">Rol</label>
            <select name="idrol" id="idrol" class="form-select">
                <option value="">-- Seleccionar --</option>
                <?php foreach($roles as $r): ?>
                    <option value="<?= $r['idrol'] ?>"
                        <?= old('idrol', $rolActual['idrol'] ?? '') == $r['idrol'] ? 'selected' : '' ?>>
                        <?= $r['rol'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="Activo" <?= old('estado', $usuario['estado'])=='Activo'?'selected':'' ?>>Activo</option>
                <option value="Inactivo" <?= old('estado', $usuario['estado'])=='Inactivo'?'selected':'' ?>>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="<?= base_url('usuarios/listar') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $footer ?>

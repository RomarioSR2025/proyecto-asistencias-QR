<?= $header ?>

<div class="container mt-4">
    <h3>Usuarios</h3>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <a href="<?= base_url('usuarios/crear') ?>" class="btn btn-primary mb-3">+ Nuevo Usuario</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Persona</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usuarios as $u): ?>
            <tr>
                <td><?= $u['idusuario'] ?></td>
                <td><?= $u['nomuser'] ?></td>
                <td><?= $u['nombres'] . ' ' . $u['apepaterno'] . ' ' . $u['apematerno'] ?></td>
                <td><?= $u['rol'] ?? 'Sin rol' ?></td>
                <td><?= $u['estado'] ?></td>
                <td>
                    <a href="<?= base_url('usuarios/editar/'.$u['idusuario']) ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="<?= base_url('usuarios/borrar/'.$u['idusuario']) ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $footer ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>
<!-- Botón para ir al formulario de nuevo registro -->
<form action="index.php" method="GET"> <!-- Es mejor usar GET para navegar -->
  <input type="hidden" name="controlador" value="usuarios" />
  <input type="hidden" name="accion" value="mostrarUsuario"/>
  <input type="submit" value="Nuevo Usuario" />
</form>

<h1>Lista de Usuarios</h1>
<p>Esta es la lista de usuarios registrados en la base de datos.</p>

<table>
  <thead>
  <tr>
    <?php
                // Esta parte puede quedarse si 'usuarioColumns' es una constante global.
                require_once "../core/constantes.php";
                foreach(usuarioColumns as $column):?>
    <th><?php echo htmlspecialchars($column); ?></th>
    <?php endforeach; ?>
    <th>Acciones</th>
  </tr>
  </thead>
  <tbody>
  <?php
            // ¡CAMBIO CLAVE! Usamos la variable $usuarios que nos pasó el controlador.
            // Ya no usamos $this->consultarTodo().
  foreach($usuarios as $usuario): ?>
  <tr>
    <!-- Ahora usamos los getters del objeto Usuario para más seguridad y encapsulamiento -->
    <td><?php echo htmlspecialchars($usuario->getNombre()); ?></td>
    <td><?php echo htmlspecialchars($usuario->getApellido()); ?></td>
    <td><?php echo htmlspecialchars($usuario->getTelefono()); ?></td>
    <td><?php echo htmlspecialchars($usuario->getEdad()); ?></td>
    <td>
      <!-- Formulario para EDITAR -->
      <form action="index.php" method="GET"> <!-- GET para navegar al formulario de edición -->
        <input type="hidden" name="controlador" value="usuario">
        <input type="hidden" name="accion" value="mostrarUsuario">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
        <button type="submit">Editar</button>
      </form>
    </td>
    <td>
      <!-- Formulario para ELIMINAR -->
      <form method="POST" action="index.php"> <!-- POST para acciones destructivas -->
        <input type="hidden" name="controlador" value="usuario">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
        <!-- ¡CAMBIO CLAVE! Usamos la variable $csrf_token que nos pasó el controlador -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</button>
      </form>
    </td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</body>
</html>
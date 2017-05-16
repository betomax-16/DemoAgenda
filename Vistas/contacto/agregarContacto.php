{{extends:templates/Template}}
{{scripts}}
<script src="<?php echo ASSETS.'js/agregarTelefono.js'; ?>" charset="utf-8"></script>
{{scriptsEnd}}
{{body}}
<div class="card">
    <div class="card-header">
        <h1>Agenda</h1>
    </div>
    <div class="card-block">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo URL.'contacto'?>">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo URL.'contacto/agregar'?>">Agregar Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Editar Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Eliminar Contacto</a>
                    </li>
                </ul>
            </div>
            <div class="card-block">
                <form action="<?php echo URL.'contacto/guardar'?>" method="post" enctype="multipart/form-data">
                    <fieldset class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="last_name">Dirección</label>
                        <input type="text" class="form-control" name="direccion">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="last_name">Email</label>
                        <input type="email" class="form-control" name="email">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="last_name">Foto</label>
                        <input type="file" class="form-control" name="foto">
                    </fieldset>
                    <button id="Add" type="button" name="button" class="btn btn-success">Agregar Telefono</button>
                    <table class="table">
                      <thead>
                        <tr>
                          <td>Telefono</td>
                          <td>Descripción</td>
                          <td>Acciones</td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{bodyEnd}}

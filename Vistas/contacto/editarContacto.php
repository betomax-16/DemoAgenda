{{extends:templates/Template}}
{{styles}}
{{stylesEnd}}
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
                        <a class="nav-link " href="<?php echo URL.'contacto/agregar'?>">Agregar Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="">Editar Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Eliminar Contacto</a>
                    </li>
                </ul>
            </div>
            <div class="card-block">
                <div class="row editar">
                    <div class="offset-md-1 col-md-6">
                        <form action="<?php echo URL.'contacto/actualizar'; ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $params['contacto']->id; ?>">
                            <fieldset class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo $params['contacto']->nombre; ?>">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="last_name">Direccion</label>
                                <input type="text" class="form-control" name="direccion" value="<?php echo $params['contacto']->direccion; ?>">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="last_name">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $params['contacto']->email; ?>">
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="last_name">Foto</label>
                                <input type="file" class="form-control" name="foto">
                            </fieldset>
                            <button id="Add" type="button" name="button">Agregar Telefono</button>
                            <table>
                                <thead>
                                    <tr>
                                        <td>Telefono</td>
                                        <td>Descripción</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      foreach ($params['contacto']->telefonos as $telefono) {
                                        echo '<tr id="'.$telefono->idTel.'">';
                                          echo '<td><input type="hidden" name="idsE[]" value="'.$telefono->idTel.'"><input type="tel" name="telefonosE[]" value="'.$telefono->telefono.'"></td> <td><input type="text" name="descripcionesE[]" value="'.$telefono->descripcion.'"></td>';
                                          echo '<td><a href="'.URL.'telefono/eliminar/'.$telefono->idTel.'">Eliminar</a></td>';
                                        echo '<tr>';
                                      }
                                    ?>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                    <div class="offset-md-1 col-md-4">
                        <img src="<?php echo ASSETS.'imagenes/'.$params['contacto']->foto; ?>" alt="" class="img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{bodyEnd}}

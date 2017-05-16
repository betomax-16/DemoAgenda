{{extends:templates/Template}}
{{styles}}
{{stylesEnd}}
{{scripts}}
{{scriptsEnd}}
{{body}}
<div class="card">
    <div class="card-header">
        <h1>Agenda</h1>
    </div>
    <div class="card-block">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL.'contacto/agregar'?>">Agregar Contacto</a>
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
                <table class="table">
                    <thead>
                        <tr>
                           <th>#</th>
                            <td>Nombre</td>
                            <td>Dirección</td>
                            <td>Email</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $i = 0;
                          foreach ($params['contactos'] as $contacto) {
                            echo '<tr id="'.$contacto->id.'">';
                            echo '<th scope="row">'.$i.'</th>';
                            echo "<td>$contacto->nombre</td> <td>$contacto->direccion</td> <td>$contacto->email</td>";
                            echo '<td><a href="'.URL.'contacto/editar/'.$contacto->id.'">Ver </a><a href="'.URL.'contacto/eliminar/'.$contacto->id.'"> Eliminar</a></td>';
                            echo '<tr>';
                            $i++;
                          }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{bodyEnd}}

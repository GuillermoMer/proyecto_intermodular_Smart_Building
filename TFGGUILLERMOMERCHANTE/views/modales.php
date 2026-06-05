
                    <!--CREAR GRUPOS-->
<div class="modal fade" id="nuevoModal" tabindex="-1" aria-labelledby="nuevoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoModalLabel">Nuevo Grupo</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="nuevoGrupo">
                    <label for="estancia">SELECCIONA EL AULA:</label><br>
                    <select name="estancia" id="estancia">
                        <?php foreach ($estancias as $estancia):?>
                            <option value="<?php echo $estancia['COD_EST']; ?>"><?php echo $estancia['COD_EST']; ?></option>
                        <?php endforeach; ?>
                    </select> <br><br>
                    <input type="text" name="nombre" id="nombre" placeholder="NOMBRE DEL GRUPO" required><br><br>
                    <textarea name="desc" id="desc" placeholder="AÑADE UNA DESCRIPCION"></textarea>

                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Grupo</button>
                </div>
            </form>
        </div>
    </div>            
</div>

                        <!--CAMBIO DE TEMPERATURA-->
<div class="modal fade" id="cambioModal" tabindex="-1" aria-labelledby="cambioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambioModalLabel">Actualizar Temperatura</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="cambiarTemp">
                    <label for="estancia">SELECCIONA EL AULA:</label> <br>
                    <select name="estancia" id="estancia">
                        <?php foreach ($estancias as $estancia):?>
                            <option value="<?php echo $estancia['COD_EST']; ?>"><?php echo $estancia['COD_EST']; ?></option>
                        <?php endforeach; ?>
                    </select> <br><br>
        
                    <input type="number" name="nuevaT" id="nuevaT" min="15" max="24" placeholder="NUEVA TEMPERATURA" required>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cambiar Temperatura</button>
                </div>
            </form>
        </div>
    </div>            
</div>    
<!--CREACION DE USUARIOS-->
<div class="modal fade" id="crearModal" tabindex="-1" aria-labelledby="crearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearModalLabel">Crear Usuario</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="crear">
                    <input type="email" name="email" id="email" placeholder="EMAIL" required><br><br>
                    <input type="text" name="nombre" id="nombre" placeholder="NOMBRE" required><br><br>
                    <input type="text" name="apellidos" id="apellidos" placeholder="APELLIDO" required><br><br>
                    <input type="password" name="password" id="password" minlength="8" placeholder="CONTRASEÑA" required><br><br>
                    
                    <select name="rol" id="rol">
                        <option value="3">Usuario</option>
                        <option value="2">Administrador</option>
                    </select><br>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>            
</div>
<!--EDITAR USUARIO-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambioModalLabel">Editar Usuario</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="editar">
                    <select name="email" id="email">
                        <?php foreach ($usuarios as $usuario):?>
                            <option value="<?php echo $usuario['EMAIL'];?>"><?php echo $usuario['EMAIL'];?></option>
                        <?php endforeach; ?>
                    </select> <br><br>
                    <input type="text" name="nombre" id="nombre" placeholder="NUEVO NOMBRE"><br><br>
                    <input type="text" name="apellidos" id="apellidos" placeholder="NUEVO APELLIDO"><br><br>
                    <input type="password" name="password" id="password" minlength="8" placeholder="NUEVA CONTRASEÑA"><br><br>
                    <select name="rol" id="rol">
                        <option value="">--------</option>
                        <option value="3">Usuario</option>
                        <option value="2">Administrador</option>
                    </select><br>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Editar Usuario</button>
                </div>
            </form>
        </div>
    </div>            
</div>
<!--BORRAR USUARIO-->
<div class="modal fade" id="borrarModal" tabindex="-1" aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="borrarModalLabel">Borrar Usuario</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="borrar">
                    <label for="email">SELECCIONA EL USUARIO</label><br>
                    <select name="email" id="email">
                        <?php foreach ($usuarios as $usuario):?>
                            <option value="<?php echo $usuario['EMAIL'];?>"><?php echo $usuario['EMAIL'];?></option>
                        <?php endforeach; ?>
                    </select> <br>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Eliminar Usuario</button>
                </div>
            </form>
        </div>
    </div>            
</div> 
                        <!--INICIAR SESION-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="login">
                    <input type="email" name="email" id="email" placeholder="EMAIL DEL USUARIO" required><br><br>
                    <input type="password" name="pass" id="pass" placeholder="CONTRASEÑA" required><br>
                </div>   
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#registroModal" data-bs-dismiss="modal" href="#"> Registrarse</button>
                    <button class="btn btn-primary"> Iniciar Sesion</button>
                </div>
            </form>
        </div>
    </div>            
</div>
                        <!--REGISTRARSE-->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Nuevo Usuario</h5>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="registrar">
                    <input type="email" name="email" id="email" placeholder="EMAIL" required><br><br>
                    <input type="text" name="nombre" id="nombre" placeholder="NOMBRE" required><br><br>
                    <input type="text" name="apellidos" id="apellidos" placeholder="APELLIDO" required><br><br>
                    <input type="password" name="password" id="password" minlength="8" placeholder="CONTRASEÑA" required><br><br>
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </div>              
</div>

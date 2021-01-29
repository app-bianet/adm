  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary">
    <!-- Brand Logo -->
    <a class="brand-link">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['sdesc_usuario'];?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="Escritorio" class="nav-link"><i class="nav-icon fa fa-desktop text-white"></i>
              <p>Escritorio<i class="right fas fa-angle-left"></i></p>
            </a>
          </li>


          <li class="nav-item">
            <?php if ($_SESSION['inventario']==1){echo'<a href="#" class="nav-link"><i class="nav-icon fa fa-cubes text-blue"></i>
              <p>Inventario<i class="right fas fa-angle-left"></i></p>
            </a>';}?>
            <ul class="nav nav-treeview child1">
              <li class="nav-item">
                <a href="" class="nav-link"><i class="far fa-folder nav-icon text-green"></i>
                  <p>Tablas<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview child2">
                  <?php if ($_SESSION['articulo']==1){echo'<li class="nav-item"><a href="Articulo" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Artículo</a></li>';}?>
                  <?php if ($_SESSION['categoria']==1){echo'<li class="nav-item"><a href="Categoria" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Categoría</a></li>';}?>
                  <?php if ($_SESSION['linea']==1){echo'<li class="nav-item"><a href="Linea" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Línea</a></li>';}?>
                  <?php if ($_SESSION['unidad']==1){echo '<li class="nav-item"><a href="Unidad" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Unidad</a></li>';}?>
                  <?php if ($_SESSION['deposito']==1){echo'<li class="nav-item"><a href="Deposito" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Deposito</a></li>';}?>
                </ul>
              </li>
              <li class="nav-item">
                <?php if ($_SESSION['opinventario']==1){echo'<a href="" class="nav-link"><i class="far fa-folder nav-icon text-red"></i>
                  <p>Operaciones<i class="right fas fa-angle-left"></i></p>
                </a>';}?>
                <ul class="nav nav-treeview child2">
                  <?php if ($_SESSION['ajustei']==1){echo'<li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Ingreso</a></li>';}?>
                  <?php if ($_SESSION['traslado']==1){echo'<li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Precios</a></li>';}?>
                  <?php if ($_SESSION['ajustep']==1){echo'<li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Traslado</a></li>';}?>
                </ul>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <?php if ($_SESSION['compras']==1){echo'<a href="#" class="nav-link"><i class="nav-icon fa fa-truck text-red"></i>
              <p>Compras y CXP<i class="right fas fa-angle-left"></i></p>
            </a>';}?>
            <ul class="nav nav-treeview child1">
              <li class="nav-item">
                <a href="" class="nav-link"><i class="far fa-folder nav-icon text-green"></i>
                  <p>Tablas<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview child2">
                  <?php if ($_SESSION['proveedor']==1){echo'<li class="nav-item"><a href="Proveedor" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Proveedor</a></li>';}?>
                  <?php if ($_SESSION['tipoproveedor']==1){echo'<li class="nav-item"><a href="TipoProveedor" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Tipos de Proveedor</a></li>';}?>
                  <?php if ($_SESSION['condpago']==1){echo'<li class="nav-item"><a href="CondPago" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Condición de Pago</a></li>';}?>
                  <?php if ($_SESSION['zona']==1){echo'<li class="nav-item"><a href="Zona" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Zona</a></li>';}?>
                </ul>
              </li>
              <li class="nav-item">
                <?php if ($_SESSION['opcompras']==1){echo'<a href="" class="nav-link"><i class="far fa-folder nav-icon text-red"></i>
                  <p>Operaciones<i class="right fas fa-angle-left"></i></p>
                </a>';}?>
                <ul class="nav nav-treeview child2">
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Ingreso</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Precios</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Traslado</a></li>
                </ul>
              </li>
            </ul>

          </li>

          <li class="nav-item">
            <?php if ($_SESSION['ventas']==1){echo'<a href="#" class="nav-link"><i class="nav-icon fa fa-cart-plus text-yellow"></i>
              <p>Ventas y CXC<i class="right fas fa-angle-left"></i></p>
              </a>';}?>
            <ul class="nav nav-treeview child1">
              <li class="nav-item">
                <a href="" class="nav-link"><i class="far fa-folder nav-icon text-green"></i>
                  <p>Tablas<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview child2">
                  <?php if ($_SESSION['cliente']==1){echo'<li class="nav-item">
                    <a href="Cliente" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Cliente</a>
                    </li>';}?>
                  <?php if ($_SESSION['tipocliente']==1){echo'<li class="nav-item">
                    <a href="TipoCliente" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Tipo de Cliente</a>
                    </li>';}?>
                  <?php if ($_SESSION['tipoprecio']==1){echo'<li class="nav-item">
                    <a href="TipoPrecio" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Tipo de Precio</a>
                    </li>';}?>
                  <?php if ($_SESSION['vendedor']==1){echo'<li class="nav-item">
                    <a href="Vendedor" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Vendedor</a>
                    </li>';}?>
                  <?php if ($_SESSION['condpago']==1){echo'<li class="nav-item">
                    <a href="CondPago" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Condición de Pago</a>
                    </li>';}?>
                  <?php if ($_SESSION['zona']==1){echo'<li class="nav-item">
                    <a href="Zona" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Zona</a>
                    </li>';}?>
                </ul>
              </li>
              <li class="nav-item">
                <?php if ($_SESSION['opventas']==1){echo'<a href="" class="nav-link"><i class="far fa-folder nav-icon text-red"></i>
                  <p>Operaciones<i class="right fas fa-angle-left"></i></p>
                </a>';}?>
                <ul class="nav nav-treeview child2">
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Ingreso</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Precios</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Traslado</a></li>
                </ul>
              </li>
            </ul>

          </li>

          <li class="nav-item">
            <?php if ($_SESSION['bancos']==1){echo'<a href="#" class="nav-link"><i class="nav-icon fas fa-landmark text-olive"></i>
              <p>Banca y Finazas<i class="right fas fa-angle-left"></i></p>
              </a>';}?>
            <ul class="nav nav-treeview child1">
              <li class="nav-item">
                <a href="" class="nav-link"><i class="far fa-folder nav-icon text-green"></i>
                  <p>Tablas<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview child2">
                  <li class="nav-item"><a href="Banco" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Bancos</a></li>
                  <li class="nav-item"><a href="Caja" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Cajas</a></li>
                  <li class="nav-item"><a href="Cuenta" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Cuenta Bancaria</a></li>
                  <li class="nav-item"><a href="Beneficiario" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Beneficiario</a></li>

                </ul>
              </li>
              <li class="nav-item">
                <?php if ($_SESSION['opbancos']==1){echo'<a href="" class="nav-link"><i class="far fa-folder nav-icon text-red"></i>
                  <p>Operaciones<i class="right fas fa-angle-left"></i></p>
                </a>';}?>
                <ul class="nav nav-treeview child2">
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Ingreso</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Ajuste de Precios</a></li>
                  <li class="nav-item"><a href="" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Traslado</a></li>
                </ul>
              </li>
            </ul>

          </li>

          <li class="nav-item">
            <?php if ($_SESSION['config']==1){echo'<a href="#" class="nav-link"><i class="nav-icon fa fa-cogs text-white"></i>
              <p>Configuracion<i class="right fas fa-angle-left"></i></p>
            </a>';}?>
            <ul class="nav nav-treeview child2">
            <?php if ($_SESSION['macceso']==1){echo'<li class="nav-item">
            <a href="MAcceso" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Mapas de Acceso</a></li>';}?>
            <?php if ($_SESSION['usuariotb']==1){echo'<li class="nav-item">
            <a href="Usuario" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Usuario</a></li>';}?>
            <?php if ($_SESSION['correlativo']==1){echo'<li class="nav-item">
            <a href="Correlativo" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Seriales</a></li>';}?>
            <?php if ($_SESSION['operacion']==1){echo'<li class="nav-item">
            <a href="Operacion" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Tipos de Operaciones</a></li>';}?>
            <?php if ($_SESSION['impuesto']==1){echo'<li class="nav-item">
            <a href="Impuesto" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Impuesto</a></li>';}?>
            <?php if ($_SESSION['moneda']==1){echo'<li class="nav-item">
            <a href="Moneda" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Moneda</a></li>';}?>
            <?php if ($_SESSION['pais']==1){echo'<li class="nav-item">
            <a href="Pais" class="nav-link"><i class="far fa-circle nav-icon text-blue"></i> Pais</a></li>';}?>
            </ul>
          </li>
        </ul>
      </nav><!-- /sidebar-menu -->
    </div><!-- /sidebar -->
  </aside>
<?php
    @session_start();

    #Importar constantes.
    include (@$_SESSION['getConsts']);

    include (PF_CONNECT_SERVER);
    include (PD_DESKTOP_ROOT_PHP."/gn.ssh.class.php");

    $CN = new ConnectSSH();
    $CN->ConnectDB($H, $U, $P, $D, $X);

    $R = $CN->getAllHost();
?>

<link rel="stylesheet" type="text/css" href="<?php echo PDS_DESKTOP_ROOT; ?>/css/vis/style.css">

<!-- Required .creating-admin-panels wrapper-->
<div class="creating-admin-panels">

    <!-- Create Row -->
    <div class="row">

        <!-- Create Column with required .admin-grid class -->
        <div class="col-md-12 admin-grid">

            <!-- Create Panel with required unique ID -->
            <div class="panel" id="p100">
                <div class="panel-heading">
                    <span class="panel-icon"><i class="fa fa-desktop"></i></span>
                    <span class="panel-title">Gestión de dispositivos</span>
                    
                    <div class="container_options_controls" style="position: absolute; top: 0; right: 10px;">
                        <label class="ml5 mr10">Filtro:</label>
                        <button class="filter btn btn-primary btn-sm active" data-filter="all">Todo</button>
                        <button class="filter btn btn-primary btn-sm" data-filter=".category-1">Ordenador</button>
                        <button class="filter btn btn-info btn-sm" data-filter=".category-2 .category-1">Enrutador</button>
                        <button class="filter btn btn-info btn-sm" data-filter=".category-2">Conmutador</button>

                        <!-- Orden -->
                        <button class="sort btn btn-default btn-sm btn_Order_Asc" data-sort="myorder:asc" style="visibility: hidden;">Asc</button>
                        <button class="sort btn btn-default btn-sm btn_Order_Desc" data-sort="myorder:desc" style="visibility: hidden;">Desc</button>

                        <!-- Split button -->
                        <div class="btn-group" style="display: inline-block;">
                            <button type="button" class="btn btn-danger btn_Order_value">Orden</button>
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li class="li_OrderAsc"><a href="#">Ascendente</a></li>
                                <li class="li_OrderDesc"><a href="#">Descendente</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="panel-body">

                    <div class="mixings-get-devices" data-example-id="contextual-panels">
                        

                        <hr class="alt short">

                        <div id="mix-items" class="mix-container">

                            <?php
                                if (@$R->num_rows > 0){
                                    $R_Count = 1;
                                    while ($Restore = @$R->fetch_array(MYSQLI_ASSOC)) {
                                        if ((bool)$Restore['router']){
                                            ?>
                                                <div class="mix category-1" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block;"></div>
                                            <?php
                                        } else {
                                            ?>
                                                <div class="mix category-2" data-myorder="<?php echo $R_Count; ?>" style="display: inline-block;"></div>
                                            <?php
                                        }
                                        $R_Count++;
                                    }
                                }
                            ?>
                            
                            <div class="gap"></div>
                            <div class="gap"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Column -->

    </div>
    <!-- End Row -->

</div>
<!-- End .admin-panels Wrapper -->

<script type="text/javascript">
    $('#mix-items').mixItUp();

    // multiselect - contextual 
    $('#multiselect-contextual').multiselect({
      buttonClass: 'multiselect dropdown-toggle btn btn-primary'
    });

    $(".li_OrderDesc").click(function(){
        $(".btn_Order_Desc").click();
        $(".btn_Order_value").text("Descendente");
    });

    $(".li_OrderAsc").click(function(){
        $(".btn_Order_Asc").click();
        $(".btn_Order_value").text("Ascendente");
    });

</script>
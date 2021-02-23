<?php
    include_once ('menu-bar.php');
    
?>

<style>
    .btn-app{
        width: 162px;
        height: 82px;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Dashboard
      </h1>
    </section>

    <section class="content">
        <div class="block" layout="row" layout-align="space-between center">
            <a href= "./clientes" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-user"></i> Clientes
            </a>
    
            <a href= "./fornecedores" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-users"></i> Fornecedores
            </a>
    
            <a href= "./funcionarios" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-id-badge"></i> Funcionários
            </a>
    
            <a href= "./produtos" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-boxes"></i> Produtos
            </a>
    
            <a href= "./condicionais" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-dollar-sign"></i> Condicionais
            </a>
    
            <a href= "./vendas" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-credit-card"></i> Vendas
            </a>
    
            <a href= "./PDV" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-desktop"></i> PDV
            </a>
    
            <a href= "./os-abertas" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-file-alt"></i> OS Aberta
            </a>
    
            <a href= "" class="btn btn-app" style="background-color:#2E4DD4; color:#fff">
                <i class="fa fa-file-alt"></i> Nota Fiscal
            </a>
        </div>

        <div class="row">
            
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fas fa-chart-line"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text">Venda Mensal</span>
                    <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fas fa-chart-line"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Venda diária</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-dollar-sign"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Condicionais</span>
                        <span class="info-box-number"></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-hand-holding-usd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Receber</span>
                        <span class="info-box-number">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            <!-- /.info-box -->
            </div>
        
        </div>
    
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="nav-tabs-custom">
                    
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gráfico de vendas</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>

                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="columnchart_values" style="position: relative; height: 300px;"></div>
                            
                        </div>
                        
                    <!-- /.box-body -->
                    </div>
                </div>
                
            </section>

            <section class="col-lg-5 connectedSortable">

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gráfico de Lucros</h3>
                        
                        <div class="pull-right box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                        <div class="tab-content no-padding">
                            <div class="chart tab-pane active" id="piechart" style="position: relative; height: 300px;"></div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
        
    </select>
    
</div>

<?php
    include_once ('footer.php');
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
<?php
    include_once ('./controller/home/home.js');
    
?>

</script>
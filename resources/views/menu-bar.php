
<header class="main-header">
    <a href="./home" class="logo" style="">
        <span class="logo-mini"><b> <img src="./public/assets/image/Logo_arte_visual_branca_mini.png" alt="Software Image-Mini"> </b></span>
        
        <span class="logo-lg"><b><img src="./public/assets/image/Logo_arte_visual_branca.png" alt="Software Image" style="width:150px;"> </b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <i class="fas fa-bars" style="color:#fff;"></i>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php
                    if($_SESSION['usuario']['proprietario'] == 'S'){

                ?>
                <li>
                    <a href="./selecioneEmpresa">
                    <i class="fas fa-building"></i> Trocar empresa
                    </a>
                </li>

                <?php
                    }
                ?>
                
                <li class="block">
                    <a href="./PDV">
                        <i class="fas fa-desktop"></i>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="./home" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="./public/assets/empresa/imagem/<?=$_SESSION['empresa']['matriz']?>/<?=$_SESSION['empresa']['imagem']?>" alt="User Image" style="width:60px">
                        <span><?=$_SESSION['empresa']['nomefantasia']?></span>
                    </a>
                </li>
                
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel" style="">
            <!--div class="pull-left image">
                <img src="./public/assets/image/user.png" class="img-circle" alt="User Image">
            </div-->
            <div class="pull-left info" style="padding: 0; left:0; position: relative;">
                <p style="font-size:18px; font-weight:"><?=$_SESSION['usuario']['name']?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU PRINCIPAL</li>
            
            <li>
                <a href="./home">
                    <i class="fa fa-home"></i> <span>INICIO</span>
                </a>
            </li>
 
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-id-card"></i> <span>CADASTRO</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href= "./empresa"><i class="fa fa-building"></i> EMPRESAS</a></li>
                    <li><a href= "./clientes"><i class="fa fa-user"></i> CLIENTES</a></li>
                    <li><a href= "./fornecedores"><i class="fa fa-users"></i> FORNECEDORES</a></li>
                    <li><a href= "./funcionarios"><i class="fa fa-id-badge"></i> FUNCIONÁRIOS</a></li>
                    <li><a href= "./transportadoras"><i class="fa fa-truck"></i> TRANSPORTADORAS</a></li>
                    <li class="block"><a href= "./usuarios"><i class="fa fa-user"></i> USUÁRIOS</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-boxes"></i> <span>PRODUTOS</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li><a href= "./produtos"><i class="fa fa-boxes"></i> PRODUTOS</a></li>
                    <li class="block"><a href= ""><i class="fa fa-toolbox"></i> SERVIÇOS</a></li>
                    <li><a href= "./categoria"><i class="fa fa-clipboard-list"></i> CATEGORIAS</a></li>
                    <li><a href= "./subcategoria"><i class="fa fa-clipboard-list"></i> SUB-CATEGORIA</a></li>
                    <li class="block"><a href= ""><i class="fa fa-border-all"></i> GRADES</a></li>
                    <li><a href= "./lanc_estoque"><i class="fa fa-dolly"></i> LANÇAMENTOS DE ESTOQUE</a></li>
                    <li class="block"><a href= ""><i class="fa fa-dolly"></i> SAÍDA DE ESTOQUE</a></li>
                    <li class="block"><a href= ""><i class="fa fa-clipboard-list"></i> HISTÓRIO DE PRODUTOS</a></li>
                    <li class="block"><a href= ""><i class="fas fa-scanner"></i> BALANÇO</a></li>
                    <li class="block"><a href= ""><i class="fa fa-clipboard-list"></i> TRANSFERÊNCIAS</a></li>

                </ul>
            </li>

            <li class="treeview block">
                <a href="#">
                    <i class="fa fa-coins"></i> <span>FINANCEIRO</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li><a href= ""><i class="fa fa-cash-register"></i> CAIXAS</a></li>
                    <li><a href= ""><i class="fa fa-money-check-alt"></i> RECEBER</a></li>
                    <li><a href= ""><i class="fa fa-money-check-alt"></i> RECEBIDAS</a></li>
                    <li><a href= ""><i class="fa fa-money-check-alt"></i> PAGAR</a></li>
                    <li><a href= ""><i class="fa fa-money-check-alt"></i> PAGAS</a></li>
                    <li><a href= ""><i class="fa fa-receipt"></i> TIPO DE DOCUMENTO</a></li>
                    <li><a href= ""><i class="fa fa-receipt"></i> HISTÓRIO BANCÁRIO</a></li>
                    
                </ul>
            </li>

            <li class="treeview block">
                <a href="#">
                    <i class="fa fa-coins"></i> <span>FATURAMENTO</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>

                <ul class="treeview-menu">
                    <li><a href= ""><i class="fa fa-cash-register"></i> CAIXAS</a></li>
                    <li><a href= "./vendas"><i class="fa fa-credit-card"></i> VENDAS</a></li>
                    <li><a href= ""><i class="fa fa-bars"></i> ORÇAMENTOS</a></li>
                    <li><a href= "./condicionais"><i class="fa fa-bars"></i> CONDICIONAIS</a></li>
                    <li><a href= "./PDV"><i class="fa fa-desktop"></i> PDV</a></li>
                    <li><a href= "./os-abertas"><i class="fa fa-file-alt"></i> OS ABERTAS</a></li>
                    <li><a href= ""><i class="fa fa-bars"></i> OS FECHADAS</a></li>
                    <li><a href= ""><i class="fa fa-file-alt"></i> NOTA FISCAL</a></li>
                    <li><a href= ""><i class="fa fa-bars"></i> NOTA DE ENTRADA</a></li>

                </ul>
            </li>

            <li class="treeview block">
                <a href="#">
                    <i class="fas fa-coins"></i> <span>CONFIGURAÇÃO</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>

                <ul class="treeview-menu">
                    <li><a href= ""><i class="fas fa-id-badge"></i> PERFIL</a></li>
                    <li><a href= ""><i class="fas fa-print"></i> IMPRESSORAS</a></li>
                    <li><a href= ""><i class="fas fa-bars"></i> LOG DO SISTEMA</a></li>
                    
                </ul>
            </li>

            <li class="treeview block">
                <a href="#">
                    <i class="fas fa-file-alt"></i><span> RELATÓRIOS</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>

                <ul class="treeview-menu">
                    <li><a href= ""><i class="fas fa-bars"></i> DRE SIMPLIFICADO</a></li>
                    <li><a href= ""><i class="fas fa-bars"></i> RELAÇÃO DE VENDAS</a></li>
                    <li><a href= ""><i class="fas fa-bars"></i> RANKING DE PRODUTOS</a></li>
                    <li><a href= ""><i class="fas fa-bars"></i> POSIÇÃO DE VENDAS</a></li>
                    <li><a href= ""><i class="fas fa-bars"></i> EXCLUSÕES DO SISTEMA</a></li>
                    

                </ul>
            </li>

            <li>
                <a href= "./logout"><i class="fas fa-sign-out-alt"></i> <span>DESCONECTAR</span></a></li>
            </li>


        </ul>

    </section>

</aside>
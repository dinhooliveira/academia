
<div id="wrapper"> 
<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><!--<img src="./view/admin/img/logo.png"/>--></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $_SESSION['nome'];?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $_SESSION['nome'];?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?=$_SESSION['nome'];?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION['nome'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="?pagina=admin&logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            <?php
                              if(isset($_GET['logout'])) 
                              {
                              $login = new ClassLogin();
                              $login->LogOut();
                              }
                             ?>
                        </li>
                    </ul>
                </li>
            </ul>
            
            
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="?pagina=admin"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    
                    <?php 
                    if($_GET['pagina']=='consultar-aluno' or $_GET['pagina']=='atualizar-aluno' or $_GET['pagina']=='cadastrar-aluno'  )
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=consultar-aluno&p=1"><i class="glyphicon glyphicon-user"></i>  Aluno</a>
                    </li>
                    
                    <?php 
                    if($_GET['pagina']=='consultar-servico' or $_GET['pagina']=='atualizar-servico')
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=consultar-servico&p=1"><i class="glyphicon glyphicon-lock"></i>  Serviço</a>
                    </li>
                      
                    <?php 
                    if($_GET['pagina']=='consultar-academia' or $_GET['pagina']=='atualizar-academia' or $_GET['pagina']=='cadastrar-academia')
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=consultar-academia&p=1"><i class="glyphicon glyphicon-home"></i>  Academia</a>
                    </li>
                       
                      <?php 
                    if($_GET['pagina']=='consultar-contrato' or $_GET['pagina']=='atualizar-contrato')
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=consultar-contrato&p=1"><i class="glyphicon glyphicon-book"></i>  Contrato</a>
                    </li> 
                   
                    
                    <?php 
                    if($_GET['pagina']=='relatorio-academia')
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=relatorio-academia"><i class="glyphicon glyphicon-book"></i> Faturamento</a>
                    </li> 
                    
                    <?php 
                    if($_GET['pagina']=='consultar-aluno')
                        echo "<li Class='active'>";
                        else
                        echo "<li>";
                    ?>
                     
                        <a href="?pagina=consultar-alunos"><i class="glyphicon glyphicon-book"></i> Consultar alunos</a>
                    </li> 
                    
                    <!--<li>lançamentos
                        
                        <a href="javascript:;" data-toggle="collapse" data-target="#lancamento"><i class="fa fa-fw fa-arrows-v"></i>  Lançamentos <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="lancamento" class="collapse">
                            <li>
                                <a href="#">Pedido - OS</a>
                            </li>
                            <li>
                                <a href="#">Despesa</a>
                            </li>
                        </ul>
                        
                    </li><!--lançamentos-->
                    
                    <!--<li><!--Consultas
                        
                        <a href="javascript:;" data-toggle="collapse" data-target="#consulta"><i class="fa fa-fw fa-arrows-v"></i>  Consultas <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="consulta" class="collapse">
                            <li>
                                <a href="#">A pagar</a>
                            </li>
                            <li>
                                <a href="?pagina=consultar-valores">Valores</a>
                            </li>
                        </ul>
                        
                    </li><!--Consultas-->
                         
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
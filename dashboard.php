<?php

require_once 'classes/template.php';
require_once 'dao/livroDAO.php';
require_once 'dao/reservaDAO.php';
require_once 'dao/emprestimoDAO.php';
require_once 'dao/exemplarDAO.php';

$template = new Template();
$livroDAO = new livroDAO();
$exemplarDAO = new exemplarDAO();
$reservaDAO = new reservaDAO();
$emprestimoDAO = new emprestimoDAO();

$template->header();
$template->sidebar();
$template->mainpanel();

?>


<div class="col-lg-3 col-sm-6">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-xs-5">
                    <div class="icon-big icon-info text-center">
                        <i class="ti-book"></i>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Livros</p>
                        <p style="font-size: 60%"><?php echo '<br/>'.$livroDAO->countAll();?></p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <hr/>
                <div class="stats">
                    <i class="ti-info"></i> Total
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-xs-5">
                    <div class="icon-big icon-info text-center">
                        <i class="ti-book"></i>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Exemplares</p>
                        <p style="font-size: 60%"><?php echo '<br/>'.$exemplarDAO->countAll();?></p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <hr/>
                <div class="stats">
                    <i class="ti-info"></i> Total
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-xs-5">
                    <div class="icon-big icon-info text-center">
                        <i class="ti-book"></i>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Reservas</p>
                        <p style="font-size: 60%"><?php echo '<br/>'.$reservaDAO->countAll();?></p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <hr/>
                <div class="stats">
                    <i class="ti-info"></i> Total
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-sm-6">
    <div class="card">
        <div class="content">
            <div class="row">
                <div class="col-xs-5">
                    <div class="icon-big icon-info text-center">
                        <i class="ti-book"></i>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Emprestimos</p>
                        <p style="font-size: 60%"><?php echo '<br/>'.$emprestimoDAO->countAll();?></p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <hr/>
                <div class="stats">
                    <i class="ti-info"></i> Total
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Livros reservados</h4>
<!--                <p class="category">Ultimos 3 Meses</p>-->
            </div>
            <div class="content">
                <div id="chartHours" >
                    <img alt="" src="grafico/DashReservLivroPorMesImg.php" title="">
                </div>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <a href="grafico/DashReservLivroPorMes.php" target="_blank">  Imprimir PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Livros emprestados</h4>
<!--                <p class="category">Ultimos 3 Meses</p>-->
            </div>
            <div class="content">
                <div id="chartHours" >
                    <img alt="" src="grafico/DashReservLivroPorMesImg.php" title="">
                </div>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <a href="grafico/DashReservLivroPorMes.php" target="_blank">  Imprimir PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Livros reservados e emprestados</h4>
<!--                <p class="category">Ultimos 3 Meses</p>-->
            </div>
            <div class="content">
                <div id="chartHours" >
                    <img alt="" src="grafico/DashReservLivroPorMesImg.php" title="">
                </div>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <a href="grafico/DashReservLivroPorMes.php" target="_blank">  Imprimir PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Livros reservados por categoria</h4>
                <!--                <p class="category">Ultimos 3 Meses</p>-->
            </div>
            <div class="content">
                <div id="chartHours" >
                    <img alt="" src="grafico/DashReservLivroPorCategMesImg.php" title="">
                </div>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <a href="grafico/DashReservLivroPorCategMes.php" target="_blank">  Imprimir PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Livros emprestados por categoria</h4>
                <!--                <p class="category">Ultimos 3 Meses</p>-->
            </div>
            <div class="content">
                <div id="chartHours" >
                    <img alt="" src="grafico/DashEmprestLivroPorCategMesImg.php" title="">
                </div>
                <div class="footer">
                    <hr>
                    <div class="stats">
                        <a href="grafico/DashEmprestLivroPorCategMes.php" target="_blank">  Imprimir PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

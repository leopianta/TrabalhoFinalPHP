<?php

class Template
{

    function header()
    {
        session_start();
        if((!isset($_SESSION['login']) == true) and (!isset($_SESSION['password']) == true))
        {
            unset($_SESSION['login']);
            unset($_SESSION['password']);
            header('location:login.php');
        }
        $logado = $_SESSION['name'];

        echo "<!doctype html>
<html lang='en'>
<head>
	<meta charset='utf-8' />
	<link rel='apple-touch-icon' sizes='76x76' href='assets/img/apple-icon.png'>
	<link rel='icon' type='image/png' sizes='96x96' href='assets/img/favicon.png'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />

	<title>Store Library</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name='viewport' content='width=device-width' />

    <!-- Bootstrap core CSS     -->
    <link href='assets/css/bootstrap.min.css' rel='stylesheet' />

    <!-- Animation library for notifications   -->
    <link href='assets/css/animate.min.css' rel='stylesheet'/>

    <!--  Paper Dashboard core CSS    -->
    <link href='assets/css/paper-dashboard.css' rel='stylesheet'/>

    <!--  Fonts and icons     -->
    <link href='http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
<link href='assets/css/themify-icons.css' rel='stylesheet'>
</head>
<body>";
    }

    function footer()
    {
        echo " <footer class=\"footer\">
            <div class=\"container-fluid\">
                <nav class=\"pull-left\">
                    <ul>

                        <li>
                            <a href=\"http://www.viannajr.edu.br\" target='_blank'>
                                Instituto Vianna Júnior
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class=\"copyright pull-right\">
                    &copy; <script>document.write(new Date().getFullYear())</script>, template made with <i class=\"fa fa-heart heart\"></i> by <a href=\"http://www.creative-tim.com\" target='_blank'>Creative Tim</a>
                </div>
            </div>
        </footer>

    </div>
</div>
</body>

    <!--   Core JS Files   -->
    <script src=\"assets/js/jquery-1.10.2.js\" type=\"text/javascript\"></script>
	<script src=\"assets/js/bootstrap.min.js\" type=\"text/javascript\"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src=\"assets/js/bootstrap-checkbox-radio.js\"></script>

</html>";

    }

    function sidebar()
    {
        echo "<div class=\"wrapper\">
        <div class=\"sidebar\" data-background-color=\"white\" data-active-color=\"danger\">

        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color=\"white | black\"
            Tip 2: you can change the color of the active button using the data-active-color=\"primary | info | success | warning | danger\"
        -->

        <div class=\"sidebar-wrapper\">
            <div class=\"logo\">
                <a href='index.php'><img src=\"assets/img/logo2.png\" height=\"75\" width=\"150\"></a>
                <h4>
                    StoreLib
                </h4>
                <ul class=\"nav\">
                <li>
                <a href=\"logout.php\">
                        <i class=\"ti-power-off\"></i>
                        <p>Exit</p>
                    </a>
                </li>
                </ul>
        </div>

            <ul class=\"nav\">
                <li>
                    <a href=\"categoria.php\">
                        <i class=\"ti-panel\"></i>
                        <p>Categoria</p>
                    </a>
                </li>
                <li>
                    <a href='editora.php'>
                        <i class=\"ti-files\"></i>
                        <p>Editora</p>
                    </a>
                </li>
                <li>
                    <a href='livro.php'>
                        <i class=\"ti-agenda\"></i>
                        <p>Livros</p>
                    </a>
                </li>
                <li>
                    <a href='autor.php'>
                        <i class=\"ti-user\"></i>
                        <p>Autores</p>
                    </a>
                </li>
                <li>
                    <a href='exemplar.php'>
                        <i class=\"ti-files\"></i>
                        <p>Exemplar</p>
                    </a>
                </li>
                <li>
                    <a href='reserva.php'>
                        <i class=\"ti-archive\"></i>
                        <p>Reserva</p>
                    </a>
                </li>";
        //if($_SESSION['perfil'] == 0){
        echo"<li>
                    <a href='tipoUsuario.php'>
                        <i class=\"ti-money\"></i>
                        <p>Perfil de usuário</p>
                    </a>
                </li>";
        //}
        //if($_SESSION['perfil'] == 0){
            echo"<li>
                    <a href='users.php'>
                        <i class=\"ti-user\"></i>
                        <p>Users</p>
                    </a>
                </li>";
        //}
        echo"
                <li>
                    <a href='reports.php'>
                        <i class=\"ti-files\"></i>
                        <p>Relatórios</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>";
    }

    function mainpanel()
    {

        date_default_timezone_set('America/Sao_Paulo');
        $data = date("F j, Y");
        
        echo "<div class=\"main-panel\">
        <nav class=\"navbar navbar-default\">
            <div class=\"container-fluid\">
                <div class=\"navbar-header\">
                    <button type=\"button\" class=\"navbar-toggle\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar bar1\"></span>
                        <span class=\"icon-bar bar2\"></span>
                        <span class=\"icon-bar bar3\"></span>
                    </button>
                    
                    <a class=\"navbar-brand\" href=\"#\">General Information</a>
                    
                </div>
                <small style='float: right'>$data</small>
                <div class=\"collapse navbar-collapse\">
                    <ul class=\"nav navbar-nav navbar-right\">
                        <!--li>
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"ti-panel\"></i>
                                <p>Stats</p>
                            </a>
                        </li>
                        <li class=\"dropdown\">
                            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                                <i class=\"ti-bell\"></i>
                                <p class=\"notification\">5</p>
                                <p>Notifications</p>
                                <b class=\"caret\"></b>
                            </a>
                            <ul class=\"dropdown-menu\">
                                <li><a href=\"#\">Notification 1</a></li>
                                <li><a href=\"#\">Notification 2</a></li>
                                <li><a href=\"#\">Notification 3</a></li>
                                <li><a href=\"#\">Notification 4</a></li>
                                <li><a href=\"#\">Another notification</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=\"#\">
                                <i class=\"ti-settings\"></i>
                                <p>Settings</p>
                            </a>
                        </li-->
                    </ul>

                </div>
            </div>
        </nav>";

    }

}
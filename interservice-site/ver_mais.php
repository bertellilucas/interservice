<?php
require_once('interService\aulaCurso.class.php');
require_once('interService\curso.class.php');

use InterService\Curso;
use InterService\AulaCurso;

$cursoId = (!empty($_GET['cursoId'])  and is_numeric($_GET['cursoId'])) ? $_GET['cursoId'] : 0;
$categoriaId = (!empty($_GET['categoriaId']) and is_numeric($_GET['categoriaId'])) ? $_GET['categoriaId'] : 0;

$curso = (empty($curso) || is_null($curso)) ? new Curso() : $curso;
$aula = (empty($aula) || is_null($aula)) ? new AulaCurso() : $aula;
$arrayCurso = null;
?>

<!doctype html>
<html lang="pt-br">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Exo|IBM+Plex+Sans|Roboto|Open+Sans|Work+Sans" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/background.css">
  <link rel="stylesheet" href="./css/carrosel.css">
  <link rel="stylesheet" href="./css/fontes.css">
  <link rel="stylesheet" href="./css/hover.css">
  <link rel="stylesheet" href="./css/imagens.css">
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/rodape.css">
  <link rel="stylesheet" href="./css/responsividade.css">
  <link rel="icon" type="image/png" href="./imagens/favicon-32x32.png" sizes="32x32" />

  <title>Sobre</title>
</head>
<body class="fundo3">
  <header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark compressed">
      <div class="offset-lg-2">
        <a class="navbar-brand" href="index.html">
          <img src="./imagens/logo_interservice-03.svg" width="30" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 130px;">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link fonte2" href="cursos.php">CURSOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fonte2" href="consultoria.html">CONSULTORIA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fonte2" href="tecnologia.html">TECNOLOGIA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fonte2" href="quemsomos.html">QUEM SOMOS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fonte2" href="contato.html">CONTATO</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <div class="container-fluid vermais">
    <div class="row">
        <h2 class="texto fonte7">Sobre<i class="fa fa-book pl-2" aria-hidden="true"></i></h2>
    </div>
  </div>
  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col-12">
          <h2 class="text-center py-5 fonte2">
            O que você vai aprender com esse curso?
          </h2>
          <div class="row">
            <div class="col-12">
              <p class="fonte2 text-justify pb-5">
                <?php
                  try{
                    /*Pego e valido os dados do curso para não exibir dados inadequados*/
                    echo $curso->montaHTMLDescricaoCurso($cursoId,$categoriaId);
                  }
                  catch(Exception $e){
                    echo $e->getMessage();
                  }
                ?>
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>

      <?php
        try{
          /*Pego e valido os dados do curso para não exibir dados inadequados*/
          echo $aula->montaHTMLAulasCurso($cursoId);
        }
        catch(Exception $e){
          echo $e->getMessage();
        }
      ?>

  </div>
  <div class="section">
    <div class="container-fluid">
      <div class="row rodape pt-3">
      <div class="col"></div>
      <div class="col-12">
        <div class="row pb-3">

          <div class="col-lg-1"></div>
          <div class="col-12 col-lg-2 d-flex justify-content-center"><a class="link color_icone scroll" href="#menu-home">Home</a></div>
          <div class="col-12 col-lg-2 d-flex justify-content-center"><a class="link color_icone scroll" href="#menu-curso">Cursos</a></div>
          <div class="col-12 col-lg-2 d-flex justify-content-center"><a class="link color_icone scroll" href="#menu-tecnologia">Tecnologia</a></div>
          <div class="col-12 col-lg-2 d-flex justify-content-center"><a class="link color_icone scroll" href="#menu-consultoria">Consultoria</a></div>
          <div class="col-12 col-lg-2 d-flex justify-content-center"><a class="link color_icone" href="contato.html">Contato</a></div>
        </div>
      </div>
      <div class="col-2"></div>
      <div class="col-12">
        <div class="row icons justify-content-center text-center">
          <div class="col-4"></div>
          <div class="col-1">
            <div class="icon-awe px-1">
              <a class="link color_icone" href="#!">
                <i class="fa fa-facebook fa-2x" aria-hidden="true"></i>
              </a>
            </div>
          </div>
          <div class="col-1">
            <div class="icon-awe px-1">
              <a class="link color_icone" href="#!">
                <i class="fa fa-instagram fa-2x" aria-hidden="true"></i>
              </a>
            </div>
          </div>
          <div class="col-1">
            <div class="icon-awe px-1">
              <a class="link color_icone" href="#!">
                <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
              </a>
            </div>
          </div>
          <div class="col-4"></div>
        </div>
      </div>
      <div class="col-12">
        <div class="">
          <p class="text-center text-white pt-2">2018 &copy; Todos os direitos reservados.</p>
        </div>
      </div>
    </div>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/efeitos.js" charset="utf-8"></script>
</body>
</html>

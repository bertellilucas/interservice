<?php

require_once('interService\categoria.class.php');
require_once('interService\curso.class.php');

use InterService\Categoria;
use InterService\Curso;

$AcaoCategoria = !empty($_POST["categoriaId"]) ?
  $_POST["categoriaId"] : 0;

$objCategoria = empty($objCategoria) || is_null($objCategoria) ? new Categoria() : $objCategoria;
?>


<!DOCTYPE html>
<html>
<head lang="pt-br">
  <meta charset="utf-8">
  <title>Cursos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Exo|IBM+Plex+Sans|Roboto|Open+Sans|Work+Sans" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/background.css">
  <link rel="stylesheet" href="./css/fontes.css">
  <link rel="stylesheet" href="./css/hover.css">
  <link rel="stylesheet" href="./css/imagens.css">
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/rodape.css">
  <link rel="stylesheet" href="./css/card.css">
  <link rel="stylesheet" href="./css/responsividade.css">
  <link rel="icon" type="image/png" href="./imagens/favicon-32x32.png" sizes="32x32" />

</head>
<body>
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
<div class="container-fluid curso1">
  <div class="row">
    <h2 class="texto fonte7">Cursos<i class="fa fa-graduation-cap" aria-hidden="true"></i></h2>
  </div>
</div>
  <section>
    <div class="container">
      <div class="row pt-5">
        <div class="col-10">
          <h4 class="fonte2 text-center font-weight-bold">
            Veja algumas das peculiaridades dos cursos interativos, que promovem excelente aprendizagem e beneficiam os estudantes.
            </h4>
            <ul class="pt-3">
              <li class="pt-3 fonte2 h5 text-justfy">
                São 100% práticos e levam o aluno a gravar os conceitos estudados.
              </li>
              <li class="pt-3 fonte2 h5">
                Como não há necessidade de montar uma turma por curso, o estudante pode iniciá-lo em qualquer período do ano e no horário que lhe for mais conveniente.
              </li>
            <li class="pt-3 fonte2 h5">
              O curso respeita o ritmo de cada estudante, pois o aluno tem a possibilidade de ouvir uma explicação quantas vezes forem necessárias e só avançará no conteúdo quando estiver apto para isso.
            </li>
          <li class="pt-3 fonte2 h5">
            Os estudantes podem optar por fazer um curso completo de determinada área ou apenas cursos avulsos.
          </li>
          </ul>

        </div>
      </div>
      <div class="row pt-5">
        <h2 class="fonte2 espaco2">Categorias:</h2>
      </div>
      <form action="cursos.php" method="post">
        <div class="row pt-5">



          <?php
          $contador = 0;
          try {
            $Arraycategorias = $objCategoria->buscarCategoria($objCategoria);
            for ($i = 0; $i < count($Arraycategorias); $i++) {

              if (($Arraycategorias[$i]->getIndicaCategoriaPai() == 'S'
                and $Arraycategorias[$i]->getCategoriaIdPai() == null) and $contador == 0) :
                $contador++;
                /*CASO SEJA CATEGORIA TECNOLOGIA*/
              ?>
               <div class="col-12 col-md-4 col-lg-4 espaco espaco2">
              <button type="submit" value=0
              class="btn btn-outline-primary btn-lg" name="categoriaId">
              <i class="fa fa-globe pr-2" aria-hidden="true"></i>
                Todas Categ.
              </button>
          </div>

            <div class="col-12 col-md-4 col-lg-4 espaco espaco2">
              <button type="submit" value=<?php echo $Arraycategorias[$i]->getCategoriaId() ?>
              class="btn btn-outline-info btn-lg" name="categoriaId">
              <i class="fa <?php echo $Arraycategorias[$i]->getCssIconeClass() ?> pr-2" aria-hidden="true"></i>

                <?php
                  /*Pego o nome da categoria aqui*/
                echo $Arraycategorias[$i]->getNomeCategoria();
                ?>

              </button>
            </div>
          <?php
            /*SE JÁ PRINTOU A PRIMEIRA CATEGORIA, PRINTO A SEGUNDA COM OUTRO ICONE*/
          elseif (($Arraycategorias[$i]->getIndicaCategoriaPai() == 'S'
            and $Arraycategorias[$i]->getCategoriaIdPai() == null) and $contador == 1) :
          ?>
          <div class="col-12 col-md-4 col-lg-4 espaco espaco2">
              <button type="submit" value=<?php echo $Arraycategorias[$i]->getCategoriaId() ?>
              class="btn btn-outline-danger btn-lg" name="categoriaId">
              <i class="fa <?php echo $Arraycategorias[$i]->getCssIconeClass() ?> pr-2" aria-hidden="true"></i>
                <?php
                  /*Pego o nome da categoria aqui*/
                echo $Arraycategorias[$i]->getNomeCategoria();
                ?>
              </button>
          </div>

          <?php
          $contador--; //Volto o contador para 0
          endif; //fim if
        }//fim for
      } //fim do try
      catch (Exception $e) {
        ?>

          <h2 class="fonte2 font-weight-bold">
            <?php
            echo $e->getMessage();
          } //fechamento do catch
          ?>
          </h2>

        </div> <!--Fim da div dos botões-->
      </form>

      <!--INICIO DA DIV DOS CURSOS-->
      <div class="row py-5">

          <?php
          try{
             echo $objCategoria->montaHTMLCategoriaSubcategoria($AcaoCategoria, $Arraycategorias);
          }
          catch (Exception $e)
          {
            echo $e->getMessage();
          }
          ?>

    <!--FIM DA DIV DOS CURSOS-->
    </div>
  </section>
  <div class="container-fluid pt-3">
    <div class="section">
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
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/efeitos.js" charset="utf-8"></script>
</html>

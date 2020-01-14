<?php

namespace InterService {
    require_once('interServiceDB/categoriaDB.class.php');
    //outras Exceptions
    use Exception;
    use InvalidArgumentException;

    define('TODAS_CATEGORIAS', 0);

    class Categoria
    {
        /*Atributos*/
        private $categoriaId;
        private $nomeCategoria;
        private $ordemExibicao;
        private $categoriaIdPai;
        private $indicaCategoriaPai;
        private $cssIconeClass;
        private $somatorioTempoCurso;

        /*Encapsulamento*/
        public function getCategoriaId()
        {
            return $this->categoriaId;
        }

        public function setCategoriaId($newCategoriaId)
        {
            $this->categoriaId = is_numeric($newCategoriaId) ? $newCategoriaId : null;
        }

        public function getNomeCategoria()
        {
            return $this->nomeCategoria;
        }

        public function setNomeCategoria($newNomeCategoria)
        {
            $this->nomeCategoria = $newNomeCategoria;
        }

        public function getOrdemExibicao()
        {
            return $this->ordemExibicao;
        }

        public function setOrdemExibicao($newOrdemExibicao)
        {
            $this->ordemExibicao = $newOrdemExibicao;
        }

        public function getCategoriaIdPai()
        {
            return $this->categoriaIdPai;
        }

        public function setCategoriaIdPai($newCategoriaIdPai)
        {
            $this->categoriaIdPai = $newCategoriaIdPai;
        }

        public function getIndicaCategoriaPai()
        {
            return $this->indicaCategoriaPai;
        }

        public function setIndicaCategoriaPai($newIndicaCategoriaPai)
        {
            $this->indicaCategoriaPai = $newIndicaCategoriaPai;
        }

        public function getCssIconeClass()
        {
            return $this->cssIconeClass;
        }

        public function setCssIconeClass($newCssIconeClass)
        {
            $this->cssIconeClass = $newCssIconeClass;
        }

        public function getSomatorioTempoCurso()
        {
            return $this->somatorioTempoCurso;
        }

        public function setSomatorioTempoCurso($newSomatorioTempoCurso)
        {
            $this->somatorioTempoCurso = $newSomatorioTempoCurso;
        }
        /*Fim encapsulamento*/

        /*Pego os dados da tela e chamo a DB*/
        public function buscarCategoria($objCategoria)
        {
             /*Seto os dados do obj e pesquiso*/
            try {
                if (is_null($objCategoria))
                    throw new Exception("Objeto da classe Categoria é nulo");

                $categoriaDB = new CategoriaDB("interServiceDB/DBInterservice.ini");
                return $rows = $categoriaDB->procuraCategoria($objCategoria);
            } catch (Exception $e) {
                throw $e;
            }

        }

        /* Function getCategoriaFilho
         * A partir de uma categoria Id passada por parâmetro, devolve todas
         * as categorias filhas dessa categoria Id
         * @param inteiro contendo a categoriaId que será buscada
         * e um array de categorias
         * @return novo array de objetos Categoria ou nulo se não encontrou
         */
        public function getCategoriaFilho($categoriaPaiId, $arrayCategoria)
        {
            if (is_null($categoriaPaiId) && empty($arrayCategoria))
                throw new Exception("Categoria Id e o array de categorias não podem ser nulos");

            $novoArrayCategoria = array();
            $numeroDeEncontros = 0;

            for ($i = 0; $i < count($arrayCategoria); $i++) {
                if ($arrayCategoria[$i]->getCategoriaIdPai() != null &&
                    $arrayCategoria[$i]->getCategoriaIdPai() == $categoriaPaiId) {
                    $novoArrayCategoria[$numeroDeEncontros++] = $arrayCategoria[$i];
                }
            }
            //var_dump($novoArrayCategoria);

            if ($numeroDeEncontros == 0)
                return null;
            else
                return $novoArrayCategoria;

        }

        public function montaHTMLCategoriaSubcategoria($categoriaPaiId, $arrayCategoria)
        {
            if (is_null($categoriaPaiId) && empty($arrayCategoria))
                throw new Exception("Categoria Id e o array de categorias não podem ser nulos");

            //echo $categoriaPaiId . '<br>';
            //var_dump($arrayCategoria);
            $htmlRetorno = "";

            foreach ($arrayCategoria as $categorias)
            {
                //Pego somente quem é categoria Pai
                if ($categorias->getIndicaCategoriaPai() == 'S' and
                    $categorias->getCategoriaIdPai() == null)
                {

                    //Verifico qual categoria o usuário procura
                    //0 = todas
                    //default, uma específica
                    switch ($categoriaPaiId)
                    {
                        case TODAS_CATEGORIAS:
                            $htmlRetorno .= <<<HTMLCATEGORIA
                            <!--INICIO DA DIV DE CATEGORIA PAI-->
                            <div class="container">
                                <div class="row pt-5">
                                    <h2 class="fonte2 espaco2">
                                    <i class="fa {$categorias->getCssIconeClass()}"></i>
                                    {$categorias->getNomeCategoria()}:</h2>
                                </div>
                            </div>
                            <!--FIM DA DIV DE CATEGORIA PAI-->
HTMLCATEGORIA;
                            $this->montaHTMLSubCategoria($htmlRetorno, $categorias->getCategoriaId(),
                            $arrayCategoria);
                            break;

                        default:
                        //Se a categoria pai procurada for igual a categoria Id percorrida
                        //Imprimo
                            if ($categorias->getCategoriaId() == $categoriaPaiId)
                            {
                                $htmlRetorno .= <<<HTMLCATEGORIA
                                <!--INICIO DA DIV DE CATEGORIA PAI-->
                                <div class="row pt-5">
                                    <h2 class="fonte2 espaco2">
                                    <i class="fa {$categorias->getCssIconeClass()}"></i>
                                    {$categorias->getNomeCategoria()}:</h2>
                                </div>
                                <!--FIM DA DIV DE CATEGORIA PAI-->
HTMLCATEGORIA;
                                $this->montaHTMLSubCategoria($htmlRetorno, $categoriaPaiId, $arrayCategoria);
                            }

                            break;


                    }/*FIM DA VERIFICAÇÃO DE QUAL TIPO DA CATEGORIA DEVE SER MONTADA*/

                }//FIM DAS CATEGORIAS Pai

            }//FIM DO FOREACH

            //var_dump($categoriaPaiIdEncontradas);
            return $htmlRetorno;
        }

        public function montaHTMLSubCategoria(& $HTML, $categoriaPaiId, $arrayCategoria)
        {
            if (is_null($categoriaPaiId))
                throw new Exception("Categoria id pai não pode ser nulla");

            $objCurso = null;
            $subCategoria = $this->getCategoriaFilho($categoriaPaiId, $arrayCategoria);

            //Se a categoria pai não tem subcategoria, exibo erro
            if (is_null($subCategoria))
            {
                $HTML .= <<<HTML_SUBCATEGORIA
                <div class="container">
                    <div class="row pt-5">
                        <h5 class='fonte2 font-weight-bold'>Não há subcategorias para essa categoria.</h5>
                    </div>
                </div>
HTML_SUBCATEGORIA;
            }

            //caso a categoria pai tenha categorias filhas, monto o HTML delas
            else
            {
                $objCurso = new Curso();
                foreach ($subCategoria as $subCategoria)
                {
                    $HTML .= <<<HTML_SUBCATEGORIA

                    <div class="container">
                        <div class="row pt-5">
                        <div class="col-10">
                            <h5 class='fonte2'>{$subCategoria->getNomeCategoria()}&nbsp - &nbsp
                            <i class="fa fa-clock-o pr-2" aria-hidden="true"></i>
                            <span>{$subCategoria->getSomatorioTempoCurso()}</span>
                            </h5>
                            </div>
                        </div>
                    </div>
HTML_SUBCATEGORIA;
                    //Populo o obj de curso com a categoria que ele pertence e mando buscar os cursos
                    $objCurso->setCategoriaId($subCategoria->getCategoriaId());

                    //chamo a função que monta o html dos cursos passando como parametro
                    //o array de cursos da categoria vigente no laço e passo o obj dessa categoria
                    //retorna o html e concateno com o HTML que será retornado para a view
                    $HTML .= $objCurso->montaHTMLCurso($objCurso->buscar($objCurso),$subCategoria);

                }
            }
        }

    }//FIM DA CLASSE
}//FIM DO NAMESPACE

?>

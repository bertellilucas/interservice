<?php

namespace InterService {

    require_once('../Model DB/cursoModel.php');

    //outras Exceptions
    use Exception;
    use InvalidArgumentException;

    class CursoController
    {
        /*Atributos*/
        private $categoriaId;
        private $cursoId;
        private $tituloCurso;
        private $tempoTotal;
        private $indicaAtivo;
        private $dataAtualizacao;
        private $descricaoCurso;

        /*Encapsulamento*/
        public function getCategoriaId()
        {
            return $this->categoriaId;
        }

        public function setCategoriaId($newCategoriaId)
        {
            $this->categoriaId = is_numeric($newCategoriaId) ? $newCategoriaId : null;
        }

        public function getCursoId()
        {
            return $this->cursoId;
        }

        public function setCursoId($newCursoId)
        {
            $this->cursoId = is_numeric($newCursoId) ? $newCursoId : null;
        }

        public function getTituloCurso()
        {
            return $this->tituloCurso;
        }

        public function setTituloCurso($newTituloCurso)
        {
            $this->tituloCurso = $newTituloCurso;
        }

        public function getTempoTotal()
        {
            return $this->tempoTotal;
        }

        public function setTempoTotal($newTempoTotal)
        {
            $this->tempoTotal = $newTempoTotal;
        }

        public function getIndicaAtivo()
        {
            return $this->indicaAtivo;
        }

        public function setIndicaAtivo($newIndicaAtivo)
        {
            $this->indicaAtivo = $newIndicaAtivo;
        }

        public function getDataAtualizacao()
        {
            return $this->dataAtualizacao;
        }

        public function setDataAtualizacao($newDataAtualizacao)
        {
            $this->dataAtualizacao = $newDataAtualizacao;
        }

        public function getDescricaoCurso()
        {
            return $this->descricaoCurso;
        }

        public function setDescricaoCurso($newDescricaoCurso)
        {
            $this->descricaoCurso = $newDescricaoCurso;
        }
        /*Fim encapsulamento*/

        /*Pego os dados da tela e chamo a DB*/
        public function buscar($objCurso)
        {
             /*Seto os dados do obj e pesquiso*/
            try {
                if (is_null($objCurso))
                    throw new Exception("Objeto da classe Curso é nulo.");

                $cursoDB = new CursoModel("../Model DB/DBInterservice.ini");
                return $rows = $cursoDB->buscarCurso($objCurso);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function montaHTMLCurso($arrayCurso, $objCategoria)
        {
            $HTMLRetorno = '';
            foreach ($arrayCurso as $curso) {
                if (is_null($curso)) {
                    $HTMLRetorno .= <<<HTMLCURSO
                            <div class="row pt-5">
                                <span class='fonte2'>Não há cursos p/ essa categoria.</span>
                            </div>
HTMLCURSO;
                } 
                else {
                    $classeCss = $objCategoria->getCategoriaIdPai() == 1 ? 'card-counter primary' : 'card-counter danger';
                    $divId = array();

                    //Utilizo isso para delimitar como deve ser a cor dos cards
                    //Se 1, então fica azul (Tecnologia)
                    //Se não, fica salmão (Negócios)
                    if ($objCategoria->getCategoriaIdPai() == 1) {
                        $divId[0] = 'pai';
                        $divId[1] = 'mostrar';
                    } else {
                        $divId[0] = 'frente';
                        $divId[1] = 'verso';
                    }

                    $HTMLRetorno .= <<<HTMLCURSO
                            <div class="col-sm-12 col-md-4 pt-4">
                                <div id="$divId[0]" class="$classeCss">
                                    <i class="fa {$objCategoria->getCssIconeClass()}"></i>
                                    <span class="count-numbers">{$curso->gettituloCurso()}</span>
                                    <span class="count-name">Carga Horária: {$curso->getTempoTotal()}</span>
                                    <div id="$divId[1]" class="card-counter2">
                                        <a href="ver_mais.php?categoriaId={$objCategoria->getcategoriaId()}&cursoId={$curso->getcursoId()}" class="text">Ver Mais</a>
                                    </div>
                                </div>
                            </div>
HTMLCURSO;
                }
            }
            return $HTMLRetorno;
        }

        public function montaHTMLDescricaoCurso($cursoId, $categoriaId)
        {
            $HTMLRetorno = "";
            try {
                if ($cursoId == 0 || $categoriaId == 0)
                    throw new Exception('Não é possível efetuar uma busca vazia.');

                $curso = new CursoController();
                $curso->setCategoriaId($categoriaId);
                $curso->setCursoId($cursoId);
                $arrayCurso = $curso->buscar($curso);

                if (count($arrayCurso) > 1)
                    throw new Exception('Não foi possível realizar a consulta.');
                else {
                    //Monto o cabeçalho da página com o nome do curso
                    $HTMLRetorno = <<<TITULO_CURSO
                    <h3 class='text-center py-1 fonte2'>
                        {$arrayCurso[0]->getTituloCurso()} - <i class="fa fa-clock-o pr-2" aria-hidden="true"></i> {$arrayCurso[0]->getTempoTotal()}
                        <hr/>
                    </h3>
TITULO_CURSO;

                    //Coloco a descrição em baixo, mas se for nulla, lanço uma excessão nova
                    /*if (is_null($arrayCurso[0]->getDescricaoCurso()))
                        throw new Exception('Não há uma descrição para esse curso no momento.');
                    else*/
                    $HTMLRetorno .= <<<DESCRI_CURSO
                    <div class='row'>
                        <div class='col-12'>
                            <p class='fonte text-justify'>
                            {$arrayCurso[0]->getDescricaoCurso()}
                            </p>
                        </div>
                    </div>
DESCRI_CURSO;
                }
            } catch (Exception $e) {
                $HTMLRetorno .= <<<ERRO_CURSO
                <h5 class="fonte2 text-center">
                  {$e->getMessage()}
                </h5>
ERRO_CURSO;
            }
            return $HTMLRetorno;
        }
    }
}
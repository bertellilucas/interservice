<?php

namespace InterService {
    require_once('../Model DB/aulaCursoModel.php');
    
    //outras Exceptions
    use Exception;
    use InvalidArgumentException;

    class AulaCursoController
    {
        /*Atributos*/
        private $categoriaId;
        private $cursoId;
        private $aulaCursoId;
        private $tituloAula;
        private $descricaoAula;
        private $ordemExibicao;
        private $indicaAtivo;

        //armazena os tópicos da aula
        private $topicosAula = Array();

        /*Encapsulamento*/
        public function getCursoId()
        {
            return $this->cursoId;
        }

        public function setCursoId($newCursoId)
        {
            $this->cursoId = is_numeric($newCursoId) ? $newCursoId : null;
        }

        public function getAulaCursoId()
        {
            return $this->aulaCursoId;
        }

        public function setAulaCursoId($newAulaCursoId)
        {
            $this->aulaCursoId = $newAulaCursoId;
        }

        public function getTituloAula()
        {
            return $this->tituloAula;
        }

        public function setTituloAula($newTituloAula)
        {
            $this->tituloAula = $newTituloAula;
        }

        public function getDescricaoAula()
        {
            return $this->descricaoAula;
        }

        public function setDescricaoAula($newDescricaoAula)
        {
            $this->descricaoAula = $newDescricaoAula;
        }

        public function getOrdemExibicao()
        {
            return $this->ordemExibicao;
        }

        public function setOrdemExibicao($newOrdemExibicao)
        {
            $this->ordemExibicao = $newOrdemExibicao;
        }

        public function getIndicaAtivo()
        {
            return $this->indicaAtivo;
        }

        public function setIndicaAtivo($newIndicaAtivo)
        {
            $this->indicaAtivo = $newIndicaAtivo;
        }

        public function getTopicosAula()
        {
            return $this->topicosAula;
        }

        public function setTopicosAula($newValue)
        {
            array_push($this->topicosAula, $newValue);
        }
        /*Fim encapsulamento*/

        /*Pego os dados da tela e chamo a DB*/
        public function buscarAula($objAula)
        {
             /*Seto os dados do obj e pesquiso*/
            try {
                if (is_null($objAula))
                    throw new Exception("Objeto da classe aula é nulo");

                $aulaDB = new AulaCursoModel("../Model DB/DBInterservice.ini");

                return $rows = $aulaDB->buscarAula($objAula);
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function montaHTMLAulasCurso($cursoId)
        {
            $HTMLRetorno = '<div class="section pb-5"> <div class="row">';
            try {
                if ($cursoId == 0)
                    throw new Exception('Não é possível efetuar uma busca vazia.');

                $aula = new AulaCursoController();
                $aula->setCursoId($cursoId);
                $ArrayAulas = $aula->buscarAula($aula);

                //Percorro as aulas
                for ($i = 0; $i < count($ArrayAulas); $i++)
                {
                    //Coloco o nome e o número da aula
                    $HTMLRetorno .=<<<AULAS
                    <div class="col-12">
                        <h4 class="py-5 fonte2 font-weight-bold">
                            {$ArrayAulas[$i]->getOrdemExibicao()}.
                            {$ArrayAulas[$i]->getTituloAula()}
                    </h4>
                    <ul>
AULAS;
                    //pego os tópicos das aulas (retorna um array com os tópicos da aula vigente)
                    $topicoAula = $ArrayAulas[$i]->getTopicosAula();

                    if(is_null($topicoAula) || empty($topicoAula)){
                        $HTMLRetorno .=<<<DESCRI_AULAS
                        <span class="h4 fonte">
                            Não há tópicos para essa aula.
                        </span>
DESCRI_AULAS;
                    }
                    else{
                        for ($j=0; $j < count($topicoAula); $j++) {
                            $HTMLRetorno .=<<<TOPICO_AULAS
                                <li class="h5 fonte">{$topicoAula[$j]}</li>
TOPICO_AULAS;
                        }
                    }

                    $HTMLRetorno .= '</ul></div>';
                }
            } 
            catch (Exception $e) {
            }
            $HTMLRetorno .= '</div> </div> ';
            return $HTMLRetorno;
        }
    }
}
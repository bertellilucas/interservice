<?php

namespace InterService
{
    require_once('../classePadrao/conexao/conexao.class.php');
    require_once("../classePadrao/IniFile.class.php");

    use ITechConnection\Conexao;
    use ITechConnection\IniFile;
    
    //outras Exceptions
    use Exception;
    use InvalidArgumentException;

    class AulaCursoModel extends Conexao
    {
        public function __construct($iniConfigBD){
            try{
               $this->_configDB = IniFile::readIniFile($iniConfigBD);
            }
            catch (Exception $e){   
                throw $e;
            }

            $this->selectProcedure = 'pr_aulaCurso_sel';
            $this->updateProcedure = '';
            $this->insertProcedure = 'pr_aulaCurso_ins';
            $this->deleteProcedure = '';
        }

        public function __destruct(){
            $this->_configDB = NULL;
            $this->selectProcedure = NULL;
            $this->updateProcedure = NULL;
            $this->insertProcedure = NULL;
            $this->deleteProcedure = NULL;
            $this->fecharConexao(); //na desconstrução do objeto, fecha-se a conexão com o BD
        }

        public function buscarAula($objAula)
        {   
            $parametros = array();
            $qtdParametros = 0;

            try
            {
                $parametros[$qtdParametros++] = (!is_null($objAula->getCursoId()) and !empty($objAula->getCursoId())) ?
                $objAula->getCursoId() : null;
                $topicoAulas = $this->buscarTopicoAula($objAula->getCursoId());
                $Aulas = $this->pesquisar($parametros); 
                
                $ArrayAula = Array();
                $i = 0;
                
                //variavel usada no for para pegar os tópicos
                $j=0;

                //Pego aqui as aulas
                foreach ($Aulas as $linha) {
                    $ArrayAula[$i] = new AulaCursoController();
                    $ArrayAula[$i]->setCursoId($linha['cursoId']);
                    $ArrayAula[$i]->setAulaCursoId($linha['aulaCursoId']);
                    $ArrayAula[$i]->setTituloAula($linha['tituloAulaCurso']);
                    $ArrayAula[$i]->setOrdemExibicao($linha['ordemExibicao']);
                    $ArrayAula[$i]->setIndicaAtivo($linha['indicaAtivo']);

                    //pego aqui as aulas do tópico vigente, sem percorrer a matriz toda
                    //busco enquanto o id da aula for == ao id da aula da tabela tópicos

                    //ISSO SÓ FUNCIONA SE AS DUAS MATRIZES ESTIVEREM ORDENADAS
                    //POR ISSO NO RETORNO DO BANCO DE DADOS DESSAS DUAS TABELAS OS RESULTADOS DEVEM ESTAR ORDENADOS
                    for (; $ArrayAula[$i]->getAulaCursoId() == $topicoAulas[$j]['aulaCursoId']; $j++) { 
                        $ArrayAula[$i]->setTopicosAula($topicoAulas[$j]['tituloTopicoAula']);
                    }
                    $i++;
                }
                return  $ArrayAula;
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }

        private function buscarTopicoAula($cursoId, $aulaId = null){
            //marreto a procedure temporária e lá em baixo volto ela como no
            //método construtor
            $this->selectProcedure = 'pr_topicoAula_sel';
            $parametros = array();
            $qtdParametros = 0;

            $parametros[$qtdParametros++] = (!is_null($cursoId) and !empty($cursoId)) ? $cursoId : null;
            $parametros[$qtdParametros++] = $aulaId;
            try
            {
                $topicoAula = $this->pesquisar($parametros);
            }catch(Exception $e){
                throw $e;
            }

            //$topicoAula = $topicoAula->fetchAll();
            //var_dump($topicoAula);
            $this->selectProcedure = 'pr_aulacurso_sel';
            return $topicoAula;
        }
    }
}
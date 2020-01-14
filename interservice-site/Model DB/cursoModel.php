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

    class CursoModel extends Conexao
    {
        public function __construct($iniConfigBD){
            try{
               $this->_configDB = IniFile::readIniFile($iniConfigBD);
            }
            catch (Exception $e){   
                throw $e;
            }

            $this->selectProcedure = 'pr_curso_sel';
            $this->updateProcedure = '';
            $this->insertProcedure = '';
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

        public function buscarCurso($objCurso)
        {   
            $parametros = array();
            $qtdParametros = 0;
            try
            {
                $parametros[$qtdParametros++] = (!is_null($objCurso->getCategoriaId()) and !empty($objCurso->getCategoriaId())) ?
                $objCurso->getCategoriaId() : null;

                $parametros[$qtdParametros++] = (!is_null($objCurso->getCursoId()) and !empty($objCurso->getCursoId())) ?
                $objCurso->getCursoId() : null;

                $parametros[$qtdParametros++] = (!is_null($objCurso->getTituloCurso()) and !empty($objCurso->getTituloCurso())) ? 
                $objCurso->getTituloCurso() : null;

                $parametros[$qtdParametros++] = ( !is_null($objCurso->getTempoTotal()) and !empty($objCurso->getTempoTotal()) ) ? 
                $objCurso->getTempoTotal() : null;

                $parametros[$qtdParametros++] = ( !is_null($objCurso->getIndicaAtivo()) and !empty($objCurso->getIndicaAtivo()) )
                ? $objCurso->getIndicaAtivo() : null;  

                $parametros[$qtdParametros++] = ( !is_null($objCurso->getDataAtualizacao()) and !empty($objCurso->getDataAtualizacao()) ) ?
                
                $objCurso->getDataAtualizacao() : null;   
                $cursos =  $this->pesquisar($parametros); 

                $ArrayCurso = Array();
                $i = 0;
                foreach ($cursos as $linha) {
                    $ArrayCurso[$i] = new CursoController();
                    $ArrayCurso[$i]->setCategoriaId($linha['categoriaId']);
                    $ArrayCurso[$i]->setCursoId($linha['cursoId']);
                    $ArrayCurso[$i]->setTituloCurso($linha['tituloCurso']);
                    $ArrayCurso[$i]->setTempoTotal($linha['tempoTotal']);
                    $ArrayCurso[$i]->setIndicaAtivo($linha['indicaAtivo']);
                    $ArrayCurso[$i]->setDataAtualizacao($linha['dataAtualizacao']);
                    $ArrayCurso[$i]->setDescricaoCurso($linha['descricaoCurso']);
                    $i++;
                }
                //var_dump($Arraycategoria[1]);
                return  $ArrayCurso;
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }
    }
}
<?php

namespace InterService
{
    require_once('classePadrao/conexao/conexao.class.php');
    require_once("classePadrao/IniFile.class.php");

    use ITechConnection\Conexao;
    use ITechConnection\IniFile;
    //outras Exceptions
    use Exception;
    use InvalidArgumentException;
    
    class CategoriaDB extends Conexao
    {
        public function __construct($iniConfigBD){
            try{
               $this->_configDB = IniFile::readIniFile($iniConfigBD);
            }
            catch (Exception $e){   
                throw $e;
            }
            
            $this->selectProcedure = 'pr_categoria_sel';
            $this->updateProcedure = null;
            $this->insertProcedure = null;
            $this->deleteProcedure = null;
            
        }

        public function __destruct(){
            $this->_configDB = NULL;
            $this->selectProcedure = NULL;
            $this->updateProcedure = NULL;
            $this->insertProcedure = NULL;
            $this->deleteProcedure = NULL;
            $this->fecharConexao();
        }

        

        public function procuraCategoria($objCategoria)
        {   
            $parametros = array();
            $qtdParametros = 0;

            try
            {
                //*    Os parametros contidos aqui devem ser EXATAMENTE aqueles esperados pela procedure
                //*    E DEVEM ESTAR NA MESMA ORDEM que foi criado na procedure
                $parametros[$qtdParametros++] = (!is_null($objCategoria->getCategoriaId()) and !empty($objCategoria->getCategoriaId())) ?
                $objCategoria->getCategoriaId() : null;
                 
                $parametros[$qtdParametros++] = (!is_null($objCategoria->getNomeCategoria()) and !empty($objCategoria->getNomeCategoria())) ? 
                $objCategoria->getNomeCategoria() : null;
            
                /*$parametros[$qtdParametros++] = ( !is_null($objCategoria->getOrdemExibicao()) and !empty($objCategoria->getOrdemExibicao()) ) ? 
                $objCategoria->getOrdemExibicao() : null;
                
                $parametros[$qtdParametros++] = ( !is_null($objCategoria->getCategoriaIdPai()) and !empty($objCategoria->getCategoriaIdPai()) )
                ? $objCategoria->getCategoriaIdPai() : null;*/
            
                $parametros[$qtdParametros++] = ( !is_null($objCategoria->getIndicaCategoriaPai()) and !empty($objCategoria->getIndicaCategoriaPai()) ) ?
                $objCategoria->getIndicaCategoriaPai() : null;   
                
                $retorno = $this->pesquisar($parametros);
               
                $Arraycategoria = Array();
                $i = 0;
                foreach ($retorno as $linha) {
                    $Arraycategoria[$i] = new Categoria();
                    $Arraycategoria[$i]->setCategoriaId($linha['categoriaId']);
                    $Arraycategoria[$i]->setNomeCategoria($linha['nomeCategoria']);
                    $Arraycategoria[$i]->setOrdemExibicao($linha['ordemExibicao']);
                    $Arraycategoria[$i]->setCategoriaIdPai($linha['categoriaIdPai']);
                    $Arraycategoria[$i]->setIndicaCategoriaPai($linha['indicaCategoriaPai']);
                    $Arraycategoria[$i]->setCssIconeClass($linha['cssClassIcone']);
                    $Arraycategoria[$i]->setSomatorioTempoCurso($linha['total_horas']);
                    $i++;
                }
                //var_dump($Arraycategoria);
                return  $Arraycategoria;

            }
            catch(Exception $e)
            {
                throw $e;
            }
           
        }

        
    }
}
    
?>
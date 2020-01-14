<?php
/*
 * Classe Conexao
 * Cria uma conexão com o database usando PDO
 * @author jonahlyn@unm.edu
 * @modifier Denis Alves
 */

namespace ITechConnection{

    error_reporting(0);

    /*Usando os namespaces do PDO*/
    use \PDO;
    use PDOException;

    //outras Exceptions
    use Exception;
    use InvalidArgumentException;
    use ITechConnection;

    abstract Class Conexao{
        // Database Connection Configuration Parameters
        // array('driver' => 'mysql','host' => '','dbname' => '','username' => '','password' => '')

        protected $_configDB;
        protected $selectProcedure;
        protected $updateProcedure;
        protected $insertProcedure;
        protected $deleteProcedure;
        
        // Database Connection
        private $dbConexao;

        /* Function abrirConexao
         * Faz a conexão com o database usando o PDO
         */
        private function abrirConexao() {
            // Verifico se a conex]aop foi estabelecida
            if ( $this->dbConexao == NULL &&
                ( !empty($this->_configDB) && !is_null($this->_configDB) ) )
            {
                // Cria a conexao
                $dsn = "" . $this->_configDB['bancoDados']['banco'] .
                            ":host="   . $this->_configDB['bancoDados']['host'] .
                            ";dbname=" . $this->_configDB['bancoDados']['dbname'];
                try
                {
                    $this->dbConexao = new PDO( $dsn, 'root', '' );
                    $this->dbConexao->exec("set names utf8");
                }
                catch( PDOException $e )
                {
                    throw new Exception('Não foi possível estabelecer conexão com o servidor.');
                }
            }
            else
                throw new Exception('Dados para conexão estão vazios, favor informa-los.');
        }

        /* Function fecharConexao
         * Fecha a conexão com o database
         */
        protected function fecharConexao() {
            if($this->estaConectadoBD()){
                $this->dbConexao = NULL;
                $this->_config = NULL;
            }
        }

        /* Function estaConectadoBD
         * Verifica se há uma conexão estabelecida com o data base
         * @return boleano true ou false
         */
        private function estaConectadoBD(){
            return $this->dbConexao == NULL ? false : true;
        }

        /* Function runQuery
         * Runs a insert, update or delete query
         * @param string sql insert update or delete statement
         * @return int count of records affected by running the sql statement.
         */
        protected function runQuery( $sql ) {
            try {
                $count = $this->dbConexao->exec($sql);
            } catch(PDOException $e) {
                throw new Exception('Um erro inesperado ocorreu.');
                //echo __LINE__.$e->getMessage();
            }
            return $count;
        }

        /* Function pesquisar
         * Executa a procedure de select setada na classe
         * @param array contendo os parâmetros que serão passados para a procedure
         * @return array associativo ou caso não retorne linhas, lança uma excessão
         */
        protected function pesquisar( $arrayParameters = null ) {
            if(is_null($this->selectProcedure) || empty($this->selectProcedure))
                throw new Exception("Select procedure vazia, não foi possível executar a pesquisa.");

            try {
                if (!$this->estaConectadoBD())
                    //Conecto no servidor caso esteja desconectado
                    $this->abrirConexao();

                //echo $this->preparaChamadaProcedure($this->selectProcedure, count($arrayParameters));
                //var_dump($arrayParameters);
                $stmt = $this->dbConexao->
                prepare($this->preparaChamadaProcedure($this->selectProcedure, count($arrayParameters)) );

                if(!$stmt)
                    throw new Exception("Não foi possível preparar a query.");

                $stmt->execute($arrayParameters);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if($stmt->rowCount() > 0) {
                    return $stmt = $stmt->fetchAll();
                }else
                    throw new Exception("Não há resultados disponíveis.");
                } catch (Exception $th) {
                    throw $th;
                }
        }

        /* Function alterar
         * Executa a procedure de update setada na classe
         * @param array contendo os parâmetros que serão passados para a procedure
         * @return inteiro contendo o número de linhas afetadas
         */
        protected function alterar($arrayParameters) {
            try {
                if (!$this->estaConectadoBD())
                    //Conecto no servidor caso esteja desconectado
                    $this->abrirConexao();

                $stmt = $this->dbConexao->
                prepare($this->preparaChamadaProcedure($this->updateProcedure, count($arrayParameters)) );

                $count = $stmt->execute($arrayParameters);
                return $count;
            } catch (Exception $th) {
                throw $th;
            }
        }

         /* Function preparaChamadaProcedure
         * Monta a chamada de uma procedure com a quantidade de parâmetros
         * @param nome da procedure e a quantidade de parâmetros que essa procedure pede
         * @return string contendo a chamada da procedure e seus parâmetros
         */
        private function preparaChamadaProcedure($nomeProcedure, $qtdParametros)
        {
            $procedureCall = "CALL $nomeProcedure (";
            /*Preparo a chamada da procedure com os parametros que foi passado*/
            if( $qtdParametros > 0)
            {
                for ($i=1; $i <= $qtdParametros; $i++) {
                    //Quando o $i for igual ao valor total do array, coloco apenas
                    //o último parametro e fecho o parenteses da query
                    //Quando $i não for igual ao valor total do array, siginifica
                    //que preciso colocar mais parâmetros, então adiciono '?,'
                    $procedureCall .= $i == $qtdParametros ?  '?)': '?, ';
                }
            }else
                $procedureCall .= ')';

            return  $procedureCall;
        }
    }
}

<?php

namespace Core\Database;

class QueryBuilder
{
    /**
     * Objeto PDO
     */
    protected $pdo;

    protected $table;

    protected $select = [];

    protected $wheres = [];

    protected $whereContent;

    protected $wheresValues = [];


    /**
     * Inicializa con el objeto PDO
     * 
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select(array $select)
    {
        $this->select = $select;
        return $this;
    }

    public function all()
    {

        $table = $this->table;

        $query = sprintf(
            "select * from %s",
            $table
        );

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS);

    }

    public function where($column, $operador, $valor)
    {
        array_push($this->wheres, [$column, $operador, $valor]);
        return $this;
    }

    protected function whereStable()
    {
        $initWhere = false;

        $wheres = $this->wheres;

        for ($i=0; $i < count($wheres); $i++) {
            if($initWhere == false){
                $this->whereContent .= " where {$wheres[$i][0]} {$wheres[$i][1]} :where$i";
            }
            else{
                $this->whereContent .= " and {$wheres[$i][0]} {$wheres[$i][1]} :where$i";
            }
            $initWhere = true;

            $this->wheresValues["where$i"] = "{$wheres[$i][2]}";
        }
    }

    public function get()
    {
        $table = $this->table;

        $select = implode(', ', $this->select);

        $initWhere = false;

        $this->whereStable();

        $query = sprintf(
            "select %s from %s %s",
            $select,
            $table,
            $this->whereContent
        );

        // die($query);

        $statement = $this->pdo->prepare($query);

        $statement->execute($this->wheresValues);

        return $statement->fetchAll(\PDO::FETCH_CLASS);
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    /*
    |----------------------------------------------
    | CRUD
    |----------------------------------------------
    */


    /**
     * Inserta un registro a la tabla pasada como parametro, segun
     * los datos pasados en un array
     * 
     * @param string $table
     * @param array $parameters
     */
    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {

            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);

            return true;

        } catch(PDOException $e) {
            return $e;
        }
    }

    /**
     * Editar la tabla especificada
     * @param string $table
     * @param array $parameters
     * @param array $wheres
     */
    public function edit( $table, $parameters,$wheres)
    {
        $where = "";
        $col = false;

        foreach ($wheres as $key => $value) {
            
            if ($col == false) {
                $where .= $key . "= :" . $key;
            } else {
                $where .= " and " . $key . "= :" . $key;
            }
            $col = true;
        }

        $param = "";

        foreach ($parameters as $key => $value) {
            static $par = false;
            if ($par == false) {
                $param .= $key . "= :" . $key;
            }
            else{
                $param .= ", " . $key . "= :" . $key;
            }
            $par = true;
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            $param,
            $where            
        );

        foreach ($wheres as $key => $value) {
            $parameters[$key] = $value;
        }



        try {

            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);

            return true;
        } catch (PDOException $e) {

            return false;
        }


    }

    /**
     * Eliminar una fila de la tabla
     */

     public function delete($table,$wheres)
     {

        $where = "";
        $col = false;

        foreach ($wheres as $key => $value) {
            
            if ($col == false) {
                $where .= $key . "= :" . $key;
            } else {
                $where .= " and " . $key . "= :" . $key;
            }
            $col = true;
        }

        $sql = sprintf(
            'DELETE FROM %s WHERE %s',
            $table,
            $where
        );


        try {

            $statement = $this->pdo->prepare($sql);

            $statement->execute($wheres);

            return true;

        } catch (PDOException $e) {

            return false;
        }



     }

}
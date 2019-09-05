<?php

namespace Core\Database;

class QueryBuilder
{
    /**
     * Objeto PDO
     */
    protected $pdo;

    /**
     * Inicializa con el objeto PDO
     * 
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Selecciona todo los datos de la tabla pasada como parametro
     * en la base de dato hace una consulta (SELECT * FROM $table)
     * 
     * @param string $table la tabla a consultar
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Seleccionar registros por columnas segun los parametros y
     * tabla
     * 
     * @
     * @param string $table La tabla de la base de datos
     * @param array $parameters
     * 
     */

    public function selectUnique($table,$parameters)
    { 
        $sql = sprintf(
            "select %s from %s",
            implode(", ", $parameters),
            $table
        );

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);

    }

    /**
     * Seleccionar con la condicional where
     * Ejm : select * from table where id = 1
     * 
     * @param string $table
     * @param array $columns
     * @param array $wheres
     */
    public function selectAlllWhere($table,$columns,$wheres)
    {   
        $where = "";

        $col = false;

        foreach ($wheres as $key => $value) {
            
            if ($col == false) {
                $where .= $key . "= :" . $key;
            }
            else{
                $where .= " and " . $key . "= :" . $key;
            }
            $col = true;
        }
        $sql = sprintf(
            "select %s from %s where %s",
            $columns == null ? "*" : implode(", ", $columns),
            $table,
            $where
        );


        $statement = $this->pdo->prepare($sql);

        $statement->execute($wheres);

        return $statement->fetchAll(PDO::FETCH_CLASS);

    }

    /**
     * Cuenta todas las filas deacuerpo al $id 
     * @param string $table
     * @param string $id
     */
    public function countSimple($table, $id = "id")
    {
        $statement = $this->pdo->prepare("select count({$id}) as countSimple from {$table}");

        $statement->execute();

        return $statement->fetch();
    }


    /**
     * Busca en la base de datos segun los parametros asignados
     * @param string $table
     * @param array $columns
     * @param array $wheres
     * @return array
     */
    public function search( $table, $columns, $wheres)
    {
        $where = "";

        $col = false;

        foreach ($wheres as $key => $value) {

            if ($col == false) {
                $where .= $key . " like :" . $key;
            } else {
                $where .= " || " . $key . " like :" . $key;
            }
            $col = true;
        }
        $sql = sprintf(
            "select %s from %s where (%s)",
            $columns == null ? "*" : implode(", ", $columns),
            $table,
            $where
        );


        $statement = $this->pdo->prepare($sql);

        $statement->execute($wheres);

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }




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


     /*
    |----------------------------------------------
    | PERSONALIZE
    |----------------------------------------------
    */

    public function pagination($table, $parameters, $base, $top){
        $sql = sprintf(
            "select %s from %s  order by id desc limit %s, %s",
            implode(", ", $parameters),
            $table,
            $base,
            $top
        );


        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function list_temp_actual($table, $parameters)
    {
        $date = date('Y-m-d');
        $date_ini = $date . " 00:00:00";
        $date_fin = $date . " 23:59:59";

        $sql = sprintf(
            "select %s from %s WHERE create_modify BETWEEN '" . $date_ini . "' AND '" . $date_fin . "' order by create_modify desc",
            implode(", ", $parameters),
            $table
        );


        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);

    }

}
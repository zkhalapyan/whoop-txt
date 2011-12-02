<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require_once('ARException.class.php');
require_once('DB.class.php');

class ActiveRecord
{
    /**
     * Represents table name i.e. "users".
     */
    private $_table;
    
    /**
     * The primary key i.e. 1.
     */
    private $_key;

    /**
     * Primary key column name i.e. "id".
     */
    private $_col;
    
    /**
     * Associative array that maps column names to column values for example for
     * a row with primary key = 1 in the users table, this will be something
     * like ["name" => "Paul Eggert", "email"=>"eggert@ucla.edu"].
     */
    private $_row_data;
    

    public function __construct($table, $key = null, $col = 'id')
    {
        $this->_table = $table;
        $this->_key = $key;
        $this->_col = $col;
    }  

    /**
     *
     * @param type $column
     * @return type 
     */
    public function __get($column)
    {
        return ($column == $this->_col)? $this->_key : $this->_row_data[$column];
    }

    /**
     *
     * @param type $column
     * @param type $value
     * @return type 
     */
    public function __set($column, $value)
    {   
        return $this->_row_data[$column] = $value;
    }
       
    public function add()
    {
        return $this->create();
    }
    
    /**
     *
     * @param type $array
     * @param type $key
     * @param type $col 
     */
    public function load($array, $key = null, $col = 'id')
    {
        if($key)
        {
            $this->_key = $key;
            $this->_col = $col;
        }

        if(is_object($array))
            $array = get_object_vars($array);

        $this->_row_data = $array;

    }

    /**
     *
     * @return t
     */
    public function getKey()
    {
        return $this->_key;
    }
    
    public function is_unique_tuple()
    {
        $where_clause = "WHERE ";
        
        foreach($this->_row_data as $column => $value)
        {
            $where_clause .= DB::mysqli()->real_escape_string($column)."='".DB::mysqli()->real_escape_string($value)."' AND ";
        }
        
        $where_clause = substr($where_clause, 0, -5);
        
        $query = 'SELECT * FROM '.$this->_table.' '.$where_clause;
                
        $result = DB::mysqli()->query($query);

        if ($result === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

	return $result->num_rows == 0 ;
    }
    
    public function is_unique($column, $value)
    {
        $query = 'SELECT * FROM '.$this->_table.
                ' WHERE '.DB::mysqli()->real_escape_string($column)."='".DB::mysqli()->real_escape_string($value)."'";

        $result = DB::mysqli()->query($query);

        if ($result === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

	return $result->num_rows == 0 ;
    }

    /**
     * If a record can be uniquely identified by the ($column, $value) tuple,
     * and the record exists, then the primary key of that record will be 
     * returned. Otherwise, false will be returned.
     * 
     * @param string $column Column name for the query.
     * @param string $value The value of the column for the query.
     * @return boolean/integer Returns the primary key of the fetched record or
     *                         false, in case the tuple is not unique or does 
     *                         not exist.  
     */
    public function fetch_id($column, $value)
    {
        $query = 'SELECT '.$this->_col.' FROM '.$this->_table.
                ' WHERE '.DB::mysqli()->real_escape_string($column)."='".DB::mysqli()->real_escape_string($value)."'";
        
        $result = DB::mysqli()->query($query);

        if ($result === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

	if($result->num_rows == 1)
        {
            $record = $result->fetch_assoc();
            return $record[$this->_col];
            
        }
        else
        {
            return false;
        }
            
    }
    
    public function create()
    {

        $fields = '(';
        $values = '(';
        
        foreach ($this->_row_data as $key => $value)
        {
            $fields .= DB::mysqli()->real_escape_string($key).', ';
            $values .= "'".DB::mysqli()->real_escape_string($value)."', ";
        }
     
        $fields = substr($fields, 0, -2).')';
        $values = substr($values, 0, -2).')';

        $query = 'INSERT INTO `'.$this->_table.'` '.$fields.' VALUES '.$values;

        if (DB::mysqli()->query($query) === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);
	
        return $this->_key = DB::mysqli()->insert_id;
    }

    public function exists()
    {
        return $this->read();
    }

    public function read()
    {
        if($this->_key === null)
            return false;
        		
        $query = 'SELECT * FROM '.$this->_table.' WHERE '.$this->_col."='".DB::mysqli()->real_escape_string($this->_key)."'";
        
        $result = DB::mysqli()->query($query);

        if ($result === false)
        {
            throw new ARException('MySQL Error: '.DB::mysqli()->error);
        }
        
        if($result->num_rows > 0)
        {
            $this->_row_data = $result->fetch_assoc();
            $result->close();
            
            return true;
        }

        return false;
        
    }


    public function update()
    {
	if(count($this->_row_data) == 0)
            return false;
        
        $new = '';
        
        foreach ($this->_row_data as $field => $value)
        {
            $new .= DB::mysqli()->real_escape_string($field)."='".DB::mysqli()->real_escape_string($value)."', ";
        }
            
        
        $new = substr($new, 0, -2);
        
        $query = 'UPDATE `'.$this->_table.'` SET '.$new.' WHERE '.$this->_col."='".DB::mysqli()->real_escape_string($this->_key)."'";
		
        if (DB::mysqli()->query($query) === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

	return true;
                
    }


    public function delete()
    {

        $query = 'DELETE FROM '.$this->_table.' WHERE '.$this->_col."='".DB::mysqli()->real_escape_string($this->_key)."'";

        if (DB::mysqli()->query($query) === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

        $this->_key = null;
        
	return true;
    }
}

?>
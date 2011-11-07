<?php

require_once('DB.class.php');


class ARException extends Exception {}

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
        return $this->_row_data[$column];
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


    public function check_unique($column, $value)
    {
        $query = 'SELECT * FROM '.$this->_table.
                ' WHERE '.DB::mysqli()->real_escape_string($column)."='".DB::mysqli()->real_escape_string($value)."'";

        $result = DB::mysqli()->query($query);

        if ($result === false)
            throw new ARException('MySQL Error: '.DB::mysqli()->error);

	return $this->_read() === 1 ?
               $result->num_rows === 1 :
               $result->num_rows === 0 ;
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
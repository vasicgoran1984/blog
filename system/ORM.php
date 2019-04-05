<?php

/**
 * Class ORM
 * @author Radomir Brkovic <radomir.brkovic@enetelsolutions.com>
 * In this class we set up ORM Active record structure  
 */

class  ORM extends DB
{

    
    /**
     * @param array $fields
     * @return mixed
     */
    public function create(array $fields){
        $itemId = $this->insert($fields);
        $item = $this->find($itemId);
        return $item;

    }


    /**
     * @param $key
     * @return $this
     */
    public function setPrimaryKey($key){
        $this->primaryKey = $key;
        return $this;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function find($id){
        $output = [];
        $item = $this->getById($id);

        $output = $item->fetchAll(\PDO::FETCH_CLASS);
        if(isset($output[0])){
            $this->attributes = (array) $output[0];

            return $this;
        } else
            return null;

    }


    /**
     * @return null
     */
    public function first(){

        $items = $this->get();
        if($items->count()){
            return $items->result()[0];
        } else
            return null;

    }


    /**
     * @param array $relations
     * @return $this
     * @throws Exception
     */
    public function with(array $relations){
       foreach ($relations as $relation){
          if(method_exists($this, $relation))
               $this->relations[] = $relation;
           else
               die("Relation {$relation} doesn't exist in ".get_class($this)." model");
       }

        return $this;
    }


    /**
     * @param $keyword
     * @param $value
     * @param $itemId
     * @return string
     */
    public function slug($keyword, $value, $itemId = null)
    {
        $this->conditional = "";

        $value = strtolower(preg_replace('/[^A-Za-z0-9-\\/]+/', '-', $value));

        $items = $this->where($keyword, $value."%", 'LIKE');

        // when we update item we have to exclude it from comparing
        if($itemId)
            $items = $items->where($this->primaryKey, $itemId, '!=');


        $items = $items->get()->pluck($keyword);

        $i = 0;
        while(true){

            if($i > 0)
                $newValue = $value."-".$i;
            else
                $newValue = $value;

            if(!in_array($newValue, $items)){
                $value = $newValue;
                break;
            }


            $i++;
        }

        return $value;

    }

    
    public function getNextId()
    {
        $item = $this->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = '{$this->table}' AND table_schema = DATABASE( )");
        if(intval($item[0]->AUTO_INCREMENT)>0)
            $nextId = intval($item[0]->AUTO_INCREMENT);
        else
            $nextId = 1;
        return $nextId;
    }

    public function set($podaci) {
        foreach($podaci as $key => $value) {
            $this->$key = $value;
        }
    }
    

}
<?php

class BestRoute {

    public $bestRoute;
    public $time;
    public $cost;
    public $data;
    public $origin;
    public $destination;
    public $unvisited_verteces = array();
    public $visited_verteces = array();
    public $verteces = array();
    public $current_vertex;
    public $hasVertexToCheck = true;  

public function findBestRoute(){
    // set current
    $this->current_vertex = $this->origin;

    // set array templates
    $this->setArray();

    while($this->hasVertexToCheck){

        // updates verteces short_time and path value
        $this->updateTimeAndPath();

        // move current vertex to visted_verteces array
        $this->moveCurrentToVisited();

        // set back the hasVertexTocheck
        $this->hasVertexToCheck = false;

        // set new current vertex and set hasVertexToCheck to true if new current vertex found
        $this->setCurrent();
    }

    if($this->verteces[$this->destination]['short_time'] && $this->verteces[$this->destination]['path']){

    $this->bestRoute = $this->verteces[$this->destination]['path'].$this->destination;
    $this->time = $this->verteces[$this->destination]['short_time'];
    $this->cost = $this->verteces[$this->destination]['cost'];
        return true;
    }
    else{
        return false;
    }

    
}

public function updateTimeAndPath(){

// Loop neighbouring verteces
foreach($this->data[$this->current_vertex] as $neighbourVertex => $value){
    
        if($this->verteces[$this->current_vertex]['short_time'] == NULL){
            // var_dump("if");
                    $this->verteces[$neighbourVertex]['short_time'] = $value['time'];
                    $this->verteces[$neighbourVertex]['cost'] = $value['cost'];
                    $this->verteces[$neighbourVertex]['path']=$this->current_vertex;
            }

        else if ($this->verteces[$this->current_vertex]['short_time'] != NULL && $this->verteces[$neighbourVertex]['short_time']!=NULL){
            // var_dump("else if");        
            if($this->verteces[$neighbourVertex]['short_time']>($this->verteces[$this->current_vertex]['short_time']+$value['time'])){
                        $this->verteces[$neighbourVertex]['short_time'] = $value["time"];
                        $this->verteces[$neighbourVertex]['cost'] = $value["cost"];
                        substr_replace($this->verteces[$neighbourVertex]['path'],$this->current_vertex,-1);
                    }
        }else if ($this->verteces[$this->current_vertex]['short_time'] != NULL && $this->verteces[$neighbourVertex]['short_time']==NULL){
            // var_dump("else if 2");        
           
                $this->verteces[$neighbourVertex]['short_time'] = $this->verteces[$this->current_vertex]['short_time']+ $value["time"];
                $this->verteces[$neighbourVertex]['cost'] = $this->verteces[$this->current_vertex]['cost']+ $value["cost"];
                $this->verteces[$neighbourVertex]['path']=$this->verteces[$this->current_vertex]['path'].$this->current_vertex;
                    

        }else if($this->verteces[$neighbourVertex]['short_time']==NULL){
            // var_dump("second else if");
            $this->verteces[$neighbourVertex]['short_time'] = $this->verteces[$this->current_vertex]['short_time']+ $value["time"];
            $this->verteces[$neighbourVertex]['cost'] = $this->verteces[$this->current_vertex]['cost']+ $value["cost"];
            $this->verteces[$neighbourVertex]['path']=$this->verteces[$this->current_vertex]['path'].$this->current_vertex;
        }

        }
}

public function setArray(){
    
    $keys = array_keys($this->data);
    foreach($keys as $key =>$value){
        array_push($this->unvisited_verteces,$value);
        
        // add with short_distance key and path key
        array_push($verteces[$value]);
        $this->verteces[$value]= array("short_time"=>NULL,"path"=>"","cost"=>"");
    
    }   

}

public function moveCurrentToVisited(){
     // Add current vertex to visited vertex
     array_push($this->visited_verteces,$this->current_vertex);

     // Remove current vertex from unvisited vertex
     if (($key = array_search($this->current_vertex, $this->unvisited_verteces)) !== false) {
             unset($this->unvisited_verteces[$key]); 
          }
}
public function setCurrent(){
    $lowestVal = 1000000;
    foreach($this->unvisited_verteces as $key => $value){
            if($this->verteces[$value]['short_time'] != NULL){
                if($lowestVal > $this->verteces[$value]['short_time']){
                    $lowestVal = $this->verteces[$value]['short_time'];
                    $this->current_vertex = $value;  
                    $this->hasVertexToCheck = true;
                }
            }
            
    
        }
}
}
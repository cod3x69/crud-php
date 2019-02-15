<?php
include_once('class.database.php');
class Crud extends Database
{
  public function __construct(){

  }
  //->select('TClient', '*', null, 'CLINom');
  public function select($table, $row = "*", $where=null, $order=null, $groupby = null){
    $query = 'SELECT '.$row.' FROM '.$table;
    if($where != null){
      $query .= ' WHERE '.$where;
    }
    if($order !=null){
      $query .= ' ORDER BY '.$order;
    }
    if ($groupby !=null){
      $query .= ' GROUP BY '.$groupby;
    }
    return $this->query($query);
  }
  //->insert('user', array(to insert), string 'ClientID, CLINom, CLIPrenom')
  public function insert($table, $value, $row=null){
    $query = ' INSERT INTO '.$table;
    if($row !=null){
      $query .= ' (' . $row . ')';
    }
    for($i=0; $i<count($value); $i++){
      if(is_string($value[$i])){

      }
    }
    $value = implode(',',$value);
    $query.= ' VALUES ('.$value.')';
    //echo $query;
    return $this->query($query);
  }

  //->delete('user', 'id=1');
  public function delete($table, $where=null){
    if($where == null){
      $query = 'DELETE '.$table;
    }
    else{
      $query = 'DELETE FROM '.$table.' WHERE '.$where;
    }
    return $this->query($query);
  }

  //->update('TClient', array('CLINom' => 'victor', 'CLIID', =>'id'), array('id=1', 'id=2') )
  public function update($table, $rows, $where){
    //Gestion de la valeur de $where
    for ($i=0; $i<count($where); $i++){
      if($i%2 != 0){
        if(is_string($where[$i])){
          //Gestion de la dernière condition du $where
          if(($i+1) != null){
            $where[$i] = '"'.$where[$i].'" AND "';
          }else{
            $where[$i] = '"'.$where[$i];
          }
        }
      }
      $where = implode(" ",$where[$i]);
      $query = 'UPDATE '.$table.' SET ';
      $keys = array_keys($rows);
      for($i = 0; $i < count($rows); $i++){
        if(is_string($rows[$keys[$i]])){
          $query .= $keys[$i].' ="'.$rows[$keys[$i]].'"';
        }
        else{
          $query .= $keys[$i].'='.$rows[$keys[$i]];
        }
        if($i != count($rows)-1){
          $query .= ',';
        }
      }
      $query .= ' WHERE '.$where;
      return $this->query($query);
    }
  }

  public function query($requete){
    $req = Database::connect()->prepare($requete);
    $req->execute();
    $selectinfo = $req->fetchAll();
    return $selectinfo;
  }

}
?>

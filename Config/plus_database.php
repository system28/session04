<?php
class database{
  private $host;
  private $user;
  private $password;
  private $db;
  private $port=5432; // Por defecto es 5432
  private $con=null;
  public function getConnection($host="curso-qa.ciunlld8zamg.us-west-2.rds.amazonaws.com",$user="cursoqa",$password="12345678", $db="db_qa",$port=5432){
   $this->host=$host;
   $this->user=$user;
   $this->password=$password;
   $this->db=$db;
   $this->port=$port;
   $this->con = pg_connect("host=".$this->host." port=".$this->port." dbname=".$this->db." user=".$this->user." password=".$this->password);
   if (!$this->con) die("Ocurrio un error al intentar la conexion");
   return $this->con;
 }
 
 public function conectar(){
  return $this->con;
  }
 }
?>

<?php
namespace Core;

class Model extends Database
{
  protected $table = null;

  public function __construct()
  {
    
  }

  public function Select($columns = "*") {
    return Database::Query("SELECT {$columns} FROM {$this->table}")->fetch();
  }
  public function SelectAll($columns = "*") {
    return Database::Query("SELECT {$columns} FROM {$this->table}")->fetchAll();
  }
}
<?php
namespace Core;

class Model
{
  protected $table = null;

  public function Select($columns = "*")
  {
    return Database::Query("SELECT {$columns} FROM {$this->table}")->fetch();
  }
  public function SelectAll($columns = "*")
  {
    return Database::Query("SELECT {$columns} FROM {$this->table}")->fetchAll();
  }

  public function Find($id)
  {
    return Database::Query("SELECT * FROM {$this->table} WHERE id={$id}")->fetch();
  }
}
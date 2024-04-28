<?php
namespace Database;

class Model
{
  protected $table = null;

  public function Select($columns = "*")
  {
    return DBConnection::Query("SELECT {$columns} FROM {$this->table}")->fetch();
  }
  public function SelectAll($columns = "*")
  {
    return DBConnection::Query("SELECT {$columns} FROM {$this->table}")->fetchAll();
  }

  public function Find($id)
  {
    return DBConnection::Query("SELECT * FROM {$this->table} WHERE id={$id}")->fetch();
  }
}
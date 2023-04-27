<?php
namespace Com\Daw2\Core;

abstract class BaseModel
{
   //Objeto de tipo PDO que se inicializa al momento de crear un objeto de la subclase
   protected $pdo;

   public function __construct()
   {
      $this->pdo = DBManager::getInstance()->getConnection();
   }
}
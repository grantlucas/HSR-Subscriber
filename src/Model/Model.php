<?php

Namespace Model;

/**
 * @file
 * Model
 *
 * Responsible for providing common functionality shared across all models
 */

abstract class Model implements ModelInterface
{
  //Database
  protected static $db;

  public function __construct()
  {
    self::openConnection();
  }

  protected static function openConnection()
  {
    //Create database connection
    $config  = parse_ini_file(__DIR__ . '/../../config.ini', true);
    try
    {
      self::$db = new \PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'] . ';charset=utf8', $config['db']['user'], $config['db']['pass']);
    }
    catch (\PDOException $e)
    {
      print("Failed to connect to database.");
      //FIXME: Need to do something to report database connection failures
      die();
    }
  }

  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    $this->$name = $value;
  }
}

<?php
/**
 * dDBManager
 *
 * @author filippo <fd@ideato.it>
 */
class fdDBManager
{
  public static function getSelectForEventLogs()
  {
    $driver_name = Doctrine_Manager::getInstance()->getCurrentConnection()->getDriverName();
    switch ($driver_name)
    {
      case 'Sqlite':
        return 'DATE(created_at) AS date';
        break;
      default:
        return 'CAST(created_at AS DATE) AS date';
        break;
    }
  }
}
?>

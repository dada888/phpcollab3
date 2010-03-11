<?php
/**
 * dDBManager
 *
 * @author filippo <fd@ideato.it>
 */
class fdDBManager
{
  public static function getSQLToFormatDateToYearMonthDay($field = 'created_at', $as = 'date')
  {
    $driver_name = Doctrine_Manager::getInstance()->getCurrentConnection()->getDriverName();
    switch ($driver_name)
    {
      case 'Sqlite':
        return 'DATE('.$field.') AS '.$as;
        break;
      default:
        return 'CAST('.$field.' AS DATE) AS '.$as;
        break;
    }
  }
}
?>

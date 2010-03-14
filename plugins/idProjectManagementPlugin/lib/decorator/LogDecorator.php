<?php
/**
 * LogDecorator
 *
 * @author filippo <fd@ideato.it>
 */
class LogDecorator
{
  protected $log;
  protected $extracted_data = array();

  public function __construct($log)
  {
    if (empty($log->message))
    {
      throw new Exception('Invalid log. The log object should have at least a "message" property');
    }

    $this->log = $log;
    $this->extracted_data = $this->extractDataFromMessage($this->log->message);
  }

  public function extractDataFromMessage($message)
  {
    $extracted_data = array();
    preg_match_all('/([\s]?[\w]+#[\w]+\s)|([\s]?[\w]+#[\w]+$)|([\s]?[\w]+#\"[\w\s\.]*\")/', $message, $matches);
    
    foreach ($matches[0] as $match)
    {
      $message = str_replace($match, '', $message);
      list($key,$value) = explode('#', $match);
      $extracted_data[trim($key)] = trim(str_replace('"','',$value));
    }
    
    $extracted_data['message'] = trim($message);
    return $extracted_data;
  }

  public function __get($name)
  {
    if ($name == 'message')
    {
      return $this->extracted_data['message'];
    }

    if (isset($this->extracted_data[$name]))
    {
      return $this->extracted_data[$name];
    }

    $value = null;
    try
    {
      $value = $this->log->$name;
    }
    catch (Doctrine_Record_UnknownPropertyException $e)
    {
    }

    return $value;
  }

  public function  __set($name, $value)
  {
    $this->log->$name = $value;
  }

  public function  __call($name, $arguments)
  {
    return $this->log->$name($arguments);
  }
}
?>

<?php

class fd_commentComponents extends sfComponents
{
  public function executeListByModel()
  {
    $this->pager = new sfDoctrinePager('fdComment', sfConfig::get('sf_confing_comments_plugin_pager_max_per_page', 10));
    $this->pager->setQuery(Doctrine::getTable('fdComment')->getQueryForListByModelAndFieldAndValue($this->model, $this->model_field, $this->model_field_value));
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    $request_paramenters = $this->getRequest()->getParameterHolder()->getAll();
    $this->module = $request_paramenters['module'];
    $this->action = $request_paramenters['action'];
    unset($request_paramenters['module'], $request_paramenters['action'], $request_paramenters['page'], $request_paramenters['sf_culture']);

    $this->parameters = '';
    foreach ($request_paramenters as $name => $value)
    {
      if($this->parameters == '')
      {
        $this->parameters .= '?';
      }
      else
      {
        $this->parameters .= '&';
      }
      $this->parameters .= $name.'='.$value;
    }

    $config = sfConfig::get('sf_confing_comments_plugin_Profile', array());
    $this->user_enabled = $config['enabled'];
  }

}
?>

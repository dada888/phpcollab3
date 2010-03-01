<?php

use_helper('Url');

function link_project($name, $id)
{
  if (!is_null($name) && !is_null($id))
  {
    return link_to($name, '@show_project?id='.$id, array('absolute_url' => false));
  }
  
  if (!is_null($name) && is_null($id))
  {
    return $name;
  }
}

function get_cass_class_based_on_project_on_time($code)
{
  switch ($code)
  {
    case Project::EXCEEDING_ESTIMATION:
      return 'yellow';
    case Project::LATE:
      return 'red';
    default:
      return 'green';
  }
}

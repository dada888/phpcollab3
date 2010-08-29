<?php

function short_name(sfGuardUser $user)
{
  return ucfirst($user->getFirstName()).' '. ucfirst(substr($user->getLastName(),0,1)).'.';
}

function get_role(sfGuardUser $user, $project_id)
{
  return ProjectUser::getRoleByUserIdAndProjectId($user->getId(), $project_id);
}

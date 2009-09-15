<div class="secondary-navigation">
  <ul>
    <li class="first active"><?php echo link_to( __('Create a new message'), '@new_message?project_id='.$sf_request->getParameter('project_id')) ?></li>
    <li><?php echo link_to( __('View all messages'), '@index_messages?project_id='.$sf_request->getParameter('project_id')) ?></li>
  </ul>
  <div class="clear"></div>
</div>

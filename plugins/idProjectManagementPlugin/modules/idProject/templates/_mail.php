<?php $body_field = isset ($body_field) ? $body_field : 'body';?>
Hi, this is your collab installation mail system.<br/>
Log: <?php echo strtolower(get_class($object)) ?> has been <?php echo $action ?>.<br/>
<br/>
<?php echo get_class($object) ?> <?php echo $object->title ?> has been <?php echo $action ?> by <?php echo $user->getUsername() ?> on <?php echo date('Y-m-d') ?>
<br/>
<?php if (isset($show) && $show === true): ?>
<h3><?php echo LogMessageGenerator::getLinkForObject($object) ?></h3>
<?php echo $object->$body_field ?>
<?php endif; ?>
<br/>
See you soon,
phpCollab3
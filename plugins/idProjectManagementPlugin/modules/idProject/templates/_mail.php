Hi, this is your collab installation mail system.<br/>
A <?php echo strtolower(get_class($object)) ?> has been <?php echo $action ?>.<br/>
<br/>
<?php echo get_class($object) ?> <?php echo $object->title ?> has been <?php echo $action ?> by <?php echo $user->getUsername() ?> on <?php echo date('Y-m-d') ?>
<br/>
<?php if (isset($show) && $show === true): ?>
<h3><?php echo $object->title ?></h3>
<?php echo $object->body ?>
<?php endif; ?>
<br/>
See you soon,
phpCollab3
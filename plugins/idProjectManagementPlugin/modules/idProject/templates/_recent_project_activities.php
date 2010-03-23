<?php use_helper('Dashboard') ?>

<?php if(count($recent_events)): ?>
  <h3>Recent Activities</h3>
  <hr />
  <ul class="recent_activities">
  <?php foreach ($recent_events as $event):?>
    <li>
      <?php echo link_project($event->getProject()->getName(), $event->getProject()->getId())?> <strong>on <?php echo format_date($event->created_at, 'MMMM dd', $sf_user->getCulture()); ?></strong>
      <p><?php echo $event->message; ?></p>
    </li>
  <?php endforeach; ?>
  </ul>
<?php endif;?>
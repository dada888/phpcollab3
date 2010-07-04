<?php use_helper('Dashboard') ?>
<?php if(count($milestones) > 0): ?>
  <?php foreach($milestones as $milestone): ?>
    <?php if (empty($color)): ?>
      <?php $color = $milestone->isLate()? 'red' : 'green';?>
    <?php endif; ?>
    <?php if (empty($label)): ?>
      <?php $label = $milestone->isLate()? 'Late' : 'Upcoming';?>
    <?php endif; ?>
    <div class="span-full box">
      <div class="span-full">
        <div class="span-5"><h3><?php echo link_to($milestone->title, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?></h3></div>
        <div class="span-2 last">
          <strong class="milestone-<?php echo $color; ?>"><?php echo $label ?></strong>
        </div>
      </div>
      <div class="span-full">
      <div class="span-5">
        For <?php echo link_to($milestone->project->name, '@show_project?id='.$milestone->project_id); ?><br/>
        <?php if (isset($milestone->in_charge) && !is_null($milestone->in_charge)): ?>
          Assgned to <strong><?php echo $milestone->getInCharge()->getProfile()->getShortName() ?></strong><br/>
        <?php endif; ?>
      </div>
      <div class="span-2 last">
        <strong class="milestone-<?php echo $color; ?>"><?php echo sprintf($days_message, get_days_of_difference($milestone->ending_date, date('Y-m-d'))); ?></strong><br/>
      </div>
      </div>
    </div>
  <?php endforeach;?>
<?php endif; ?>
<?php if(count($milestones) > 0): ?>
  <div class="span-6 last">
    <div class="milestone-<?php echo $color; ?> padding-3">
      <strong><?php echo $label ?></strong>
    </div>
  </div>
  <div class="span-6 milestone-thin-<?php echo $color; ?> last">
    <?php foreach($milestones as $milestone): ?>
      <div class="span-6 last report dashboard-row">
        <div class="span-6 last padding-3">
          <?php echo link_to($milestone->title, '@show_milestone?project_id='.$milestone->project_id.'&milestone_id='.$milestone->id) ?>
          for <?php echo link_to($milestone->project->name, '@show_project?id='.$milestone->project_id); ?>
        </div>
        <?php if (isset($milestone->in_charge) && !is_null($milestone->in_charge)): ?>
          <div class="span-6 padding-3">
            Assgned to <strong><?php echo $milestone->getInCharge()->getProfile()->getShortName() ?></strong>
          </div>
        <?php endif; ?>
        <div class="span-6 last <?php echo $color; ?> padding-3">
          <strong><?php echo sprintf($days_message, get_days_of_difference($milestone->ending_date, date('Y-m-d'))); ?></strong>
        </div>
      </div>
    <?php endforeach;?>
  </div>
<?php endif; ?>
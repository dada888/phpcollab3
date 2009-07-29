<?php slot('title', __('Roadmap')) ?>

<?php foreach ($project->Milestones as $milestone): ?>
  <div class="block" id="<?php echo str_replace(' ', '_', $milestone->getTitle()); ?>">
    <?php include_partial('idProject/roadmap_menu', array('project' => $project)); ?>
    <div class="content">
      <h2 class="title"><?php echo __('Milestone').': '.$milestone->getTitle() ?></h2>
      <div class="inner">
          <table class="table">
            <tr>
              <th class="first">&nbsp;</th>
              <th><?php echo __('Title') ?></th>
              <th><?php echo __('Description') ?></th>
              <th><?php echo __('Starting date') ?></th>
              <th><?php echo __('Ending date') ?></th>
              <th class="last">&nbsp;</th>
            </tr>


            <tr class="odd">
              <td>&nbsp;</td>
              <td><?php echo link_to($milestone->getTitle(), '@show_milestone?project_id='.$project->getId().'&milestone_id='.$milestone->getId()) ?></td>
              <td><?php echo $milestone->getDescription() ?></td>
              <td><?php echo $milestone->getStartingDate() ?></td>
              <td><?php echo $milestone->getEndingDate() ?></td>
              <td>&nbsp;</td>
            </tr>

          </table>
      </div>
    </div>
    <div class="content">
      <h2 class="title"><?php echo __("Milestone's issues list") ?></h2>
      <div class="inner">

        <table class="table">
          <?php if (count($milestone->Issues) !== false && count($milestone->Issues) == 0): ?>
            <tr class="odd">
              <td class="first">&nbsp;</td>
              <td colspan="6"><?php echo __('No Results') ?></td>
              <td class="last">&nbsp;</td>
            </tr>
          <?php else: ?>
            <?php foreach ($milestone->Issues as $issue): ?>
              <tr class="odd">
                <td><?php echo link_to('#'.$issue->getId(), '@show_issue?project_id='.$issue->project_id.'&issue_id='.$issue->getId()) ?></td>
                <td><?php echo $issue->getTitle() ?></td>
                <td><?php echo $issue->getStatus() ?></td>
                <td><?php echo $issue->getPriority() ?></td>
                <td><?php echo $issue->getStartingDate() ?></td>
                <td><?php echo $issue->getEndingDate() ?></td>
                <td></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </table>

      </div>
    </div>
  </div>
<?php endforeach; ?>
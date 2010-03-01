<?php slot('title', __('Analisys gantt chart')) ?>

<div class="block" id="gannt_chart">
  <?php include_partial('gantt_chart_menu', array('project_id' => $sf_request->getParameter('project_id'))); ?>
  <div class="content">
    <h2 class="title"><?php echo __('Analysis gantt chart') ?></h2>
    <div class="inner">
      <div class="flash">
        <div class="message">
          <form action="<?php echo url_for('@show_analysis_gantt?project_id='.$sf_request->getParameter('project_id')) ?>" method="get" class="form">
            <?php echo $form ?>
            <input type="submit" value="Show analysis gantt chart" />
          </form>
        </div>
      </div>

      <?php if ($show_gantt && $resources): ?>
        <div id="chart1div"></div>
        <script type="text/javascript">
           var chart1 = new FusionCharts("<?php echo retriveSwfUrl() ?>", "<?php echo __($title) ?>", "750", "450");
           chart1.setDataURL(escape("<?php echo url_for('@xml_analysis_gantt?project_id='.$sf_request->getParameter('project_id').'&resources='.$resources.'&sf_format=xml') ?>"));
           chart1.render("chart1div");
        </script>

        <div id="legenda">
          <h3><?php echo __('Legenda') ?></h3>
          <p><?php echo __('This chart considers %issues% out of %total_issue% issues (%issue_no_estimated% with no estimated time)',
                            array('%issues%' => $issues_with_estimated_time['issues'],
                                  '%total_issue%' => $issues_number['issues'],
                                  '%issue_no_estimated%' => ($issues_number['issues'] - $issues_with_estimated_time['issues']))); ?></p>
          <p>
            <?php echo __('Issue with estimated time:'); ?><br />
            <?php foreach ($issues_by_tracker_with_estimated_time as $tracker => $number):?>
              <?php $tracker = !($tracker == '') ? $tracker : __('empty') ; ?>
              <p><?php echo __('%number% issues with tracker %tracker%',
                            array('%number%' => $number,
                                  '%tracker%' => $tracker)); ?></p>
            <?php endforeach;?>
          </p>
          <p>
            <?php echo __('Issue with no estimated time:'); ?><br />
            <?php foreach ($issues_by_tracker_without_estimated_time as $tracker => $number):?>
              <?php $tracker = !($tracker == '') ? $tracker : __('empty') ; ?>
              <p><?php echo __('%number% issues with tracker %tracker%',
                            array('%number%' => $number,
                                  '%tracker%' => $tracker)); ?></p>
            <?php endforeach;?>
          </p>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>
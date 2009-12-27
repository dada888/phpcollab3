<?php slot('title', __('Project status gantt chart')) ?>

<div class="block" id="gannt_chart">
  <?php include_partial('gantt_chart_menu', array('project_id' => $sf_request->getParameter('project_id'))); ?>
  <div class="content">
    <h2 class="title"><?php echo __('Project status gantt chart') ?></h2>
    <div class="inner">

      <?php if ($show_gantt): ?>
        <div id="chart1div"></div>
        <script type="text/javascript">
           var chart1 = new FusionCharts("<?php echo retriveSwfUrl() ?>", "<?php echo __($title) ?>", "750", "450");
           chart1.setDataURL(escape("<?php echo url_for('@xml_project_status_gantt?project_id='.$sf_request->getParameter('project_id').'&sf_format=xml') ?>"));
           chart1.render("chart1div");
        </script>

        <div id="legenda">
          <h3><?php echo __('Legenda')?></h3>
          <p><?php echo __('Time for completing the project: %time% hours', array('%time%' => $estimated_time_to_end)); ?></p>
          <p><?php echo __('Estimated ending date: %end_date%', array('%end_date%' => $estimated_end_date)); ?></p>
          <p><?php echo __('%issues% closed issues', array('%issues%' => $closed_issues_count)); ?></p>
          <p><?php echo __('%issues% new issues', array('%issues%' => $new_issues_count)); ?></p>
          <p><?php echo __('%issues% invalid issues', array('%issues%' => $invalid_issues_count)); ?></p>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>
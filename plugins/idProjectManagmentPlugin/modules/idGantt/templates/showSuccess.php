<?php slot('title', __('Gantt chart')) ?>

<div class="block" id="gannt_chart1">
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
    </div>
  </div>
</div>
<div class="block" id="gannt_chart2">
  <?php include_partial('gantt_chart_menu', array('project_id' => $sf_request->getParameter('project_id'))); ?>
  <div class="content">
    <h2 class="title"><?php echo __('Project status gantt chart') ?></h2>
    <div class="inner">
      <div class="flash">
        <div class="message">
          <form action="<?php echo url_for('@show_project_status_gantt?project_id='.$sf_request->getParameter('project_id')) ?>" method="get" class="form">
            <input type="submit" value="Show project status gantt chart" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

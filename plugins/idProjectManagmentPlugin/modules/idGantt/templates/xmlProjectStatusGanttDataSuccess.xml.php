<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" ?>
<chart dateFormat='yyyy/mm/dd'
       showTaskNames='1'
       ganttWidthPercent='80'
       gridBorderAlpha='100'
       canvasBorderColor='333333'
       canvasBorderThickness='0'
       hoverCapBgColor='FFFFFF' 
       hoverCapBorderColor='333333'
       extendcategoryBg='0'
       ganttLineColor='99cc00'
       ganttLineAlpha='20'
       baseFontColor='333333'
       gridBorderColor='99cc00'>

    <categories bgColor='333333' fontColor='99cc00' isBold='1' fontSize='14' >
      <?php list($year, $month) = explode('/', $gantt_starting_date); ?>
      <?php $date = date('Y/m/d', strtotime("$year/$month/01 +1 months")); ?>
      <category start='<?php echo $gantt_starting_date ?>' 
                end='<?php echo $year ?>/<?php echo $month ?>/<?php echo getLastDayOfMonth($year, $month) ?>'
                name='<?php echo $month ?>/<?php echo $year ?>' />
      <?php while(isDateInBetweenByMonth($date, $gantt_starting_date, $gantt_ending_date)): ?>

        <?php list($year, $month) = explode('/', $date); ?>
        <?php $end_date = getLatestDateOfMonth($year, $month); ?>
      
        <?php if (isLastCategoryByMonth($date, $gantt_ending_date)): ?>
          <?php $end_date = $gantt_ending_date; ?>
        <?php endif; ?>
        <category start='<?php echo $year ?>/<?php echo $month ?>/01' 
                  end='<?php echo $end_date ?>'
                  name='<?php echo $month ?>/<?php echo $year ?>' />

        <?php $date = date('Y/m/d', strtotime("$date +1 months")); ?>
      <?php endwhile; ?>
    </categories>

    <?php if ($days > 0) :?>
      <categories bgColor='99cc00' bgAlpha='40' fontColor='333333' align='center' fontSize='10' isBold='1'>
      <?php $date = $gantt_starting_date; ?>
      <?php while(isDateInBetweenByDay($date, $gantt_starting_date, $gantt_ending_date)): ?>
        <category start='<?php echo $date ?>' end='<?php echo $date ?>' name='' />
        <?php $date = date('Y/m/d', strtotime("$date +1 days")); ?>
      <?php endwhile; ?>
      </categories>
    <?php endif;?>

    <processes positionInGrid='right' align='center' headerText='Closed, open and invalid issues' fontColor='333333' fontSize='10' bgColor='99cc00' headerbgColor='333333' headerFontColor='99cc00' headerFontSize='12' bgAlpha='40'>
      <?php foreach($closed_issues as $index => $issue): ?>
        <process Name='<?php echo $issue->getTitle(); ?>' id='<?php echo $issue->getId(); ?>' />
      <?php endforeach;?>

      <?php foreach($new_issues as $index => $issue): ?>
        <process Name='<?php echo $issue->getTitle(); ?>' id='<?php echo $issue->getId(); ?>' />
      <?php endforeach;?>


      <?php foreach($invalid_issues as $index => $issue): ?>
        <process Name='<?php echo $issue->getTitle(); ?>' id='<?php echo $issue->getId(); ?>' />
      <?php endforeach;?>
    </processes>

    <tasks>
      <?php foreach($closed_issues as $index => $issue): ?>
        <task hoverText='<?php echo __('Spent time: %hours% hours', array('%hours%' =>  $issue->getTotalLogTime())); ?>' processId='<?php echo $issue->getId(); ?>'
              start='<?php echo format_date($issue->starting_date, 'yyyy/MM/dd') ?>' end='<?php echo format_date($issue->ending_date, 'yyyy/MM/dd') ?>'
              id='<?php echo $issue->getId(); ?>' color='99cc00' alpha='60' />
      <?php endforeach;?>

      <?php foreach($new_issues as $index => $issue): ?>
        <task hoverText='<?php echo __('Title: '). $issue->getTitle(); ?>' processId='<?php echo $issue->getId(); ?>'
              start='<?php echo date('Y/m/d'); ?>' end='<?php echo retrive_date_from_hours($issue->estimated_time) ?>'
              id='<?php echo $issue->getId(); ?>' color='99cc00' alpha='60' />
      <?php endforeach;?>


      <?php foreach($invalid_issues as $index => $issue): ?>
        <task hoverText='<?php echo __('Spent time: %hours% hours', array('%hours%' =>  $issue->getTotalLogTime())); ?>' processId='<?php echo $issue->getId(); ?>'
              start='<?php echo format_date($issue->starting_date, 'yyyy/MM/dd') ?>' end='<?php echo format_date($issue->ending_date, 'yyyy/MM/dd') ?>'
              id='<?php echo $issue->getId(); ?>' color='99cc00' alpha='60' />
      <?php endforeach;?>
    </tasks>

  <trendlines>
    <line start="<?php echo $project_starting_date ?>" displayValue="Start date" color="00FF00" thickness="2" dashed="1"/>
    <?php if (date('Y/m/d') >= $project_starting_date): ?>
      <line start="<?php echo date('Y/m/d') ?>" displayValue="<?php echo __('Today') ?>" isTrendZone="1" alpha="50" color="D49849"/>
    <?php endif; ?>
    <line start="<?php echo $estimated_ending_date ?>" end="<?php echo $estimated_ending_date ?>" displayValue="Estimated end date" isTrendZone="1" alpha="20" color="DAA520"/>
    <?php if (!empty($project_ending_date)): ?>
      <line start="<?php echo $project_ending_date ?>" end="<?php echo $project_ending_date ?>" displayValue="End date" isTrendZone="1" alpha="20" color="FF5904"/>
    <?php endif; ?>
  </trendlines>
</chart>
<?php slot('title', __('Revision Details')) ?>

<div class="block" id="block-text">
  <div class="content">
      <h2 class="title"><?php echo __('Details from revision') ?> <?php echo $logentry->getLogRevisionNumber() ?></h2>
      <div class="inner">
        <p class="first"><?php
                              echo __('Revision %revision_id% has been committed on %date% by %user% .',
                                      array(
                                            '%revision_id%' => $logentry->getLogRevisionNumber(),
                                            '%date%' => format_date($logentry->getDate(), 'd'),
                                            '%user%' => $logentry->getAuthor()
                                           )
                                     )
                          ?></p>
        <p><span class="hightlight"><?php echo __('Message') ?> : <?php echo $logentry->getMessage() ?></span></p>
      </div>
    </div>
</div>

<div class="block" id="block-lists">
    <div class="content">
      <h2 class="title"><?php echo __('Modified files') ?></h2>
      <div class="inner">
        <ul class="list">
        <?php
        foreach ($logentry->getPaths() as $modification)
        {
          ?>
          <li>
            <div class="left"><?php echo $modification['action'] ?></div>
              <div class="item"><p><?php echo $modification['path'] ?> [<?php echo link_to("diff", '@show_diff_list_url?path='.urlencode(urlencode($modification['path']))) ?>]</p></div>
          </li>
          <?php
        }
        ?>
        </ul>
      </div>
    </div>
  </div>
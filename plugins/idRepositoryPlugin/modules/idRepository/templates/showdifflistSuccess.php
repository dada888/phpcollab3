<?php slot('title', __('Revision List')) ?>

<div class="block" id="block-tables">
  <div class="content">
    <h2 class="title"><?php echo __('Revision list for %path%', array('%path%' => urldecode($path))) ?></h2>
      <div class="inner">
        <form action="<?php echo url_for('@show_diff') ?>" method="post" class="form" >
        <?php if (isset($form_invalid)) { ?>
          <div class="flash">
            <div class="message error">
              <p><strong><?php echo __('Warning!')?></strong></p>
              <?php if ($form->hasGlobalErrors()) { ?>
                <ul class="error_list">
                  <?php foreach ($form->getGlobalErrors() as $name => $error) { ?>
                    <?php if (!$name) { ?>
                      <li><?php echo $error ?></li>
                    <?php } ?>
                  <?php } ?>
                </ul>
              <?php }
                    if ($form['revision_left']->hasError())
                    {
                      ?>
                      <ul class="error_list">
                         <li><?php echo $form['revision_left']->getError() ?></li>
                      </ul>
                      <?php
                    }

                    if ($form['revision_right']->hasError())
                    {
                      ?>
                      <ul class="error_list">
                         <li><?php echo $form['revision_right']->getError() ?></li>
                      </ul>
                      <?php
                    }
              ?>
            </div>
          </div>
        <?php } ?>
          <table class="table">
            <tr>
              <th class="first"><?php echo __('Revision Number') ?></th>
              <th colspan="2"></th>
              <th><?php echo __('Date') ?></th>
              <th><?php echo __('Author') ?></th>
              <th><?php echo __('Message') ?></th>
              <th class="last"><?php echo __('&nbsp;') ?></th>
            </tr>
            <?php
            $number_of_revision = count($data);
            $printed_line  = 0;
            $left = $form['revision_left']->render();
            $right = $form['revision_right']->render();
            foreach($data as $key => $revision){
              ?>
              <tr class="odd">
                <td><?php echo "".$revision->getLogRevisionNumber().""?></td>
                <td><?php
                if ($printed_line != $number_of_revision-1)
                {
                   echo $left[$printed_line]['input'];
                }
                ?></td>
                <td><?php
                if ($printed_line != 0)
                {
                  echo $right[$printed_line]['input'];
                }
                ?></td>
                <td><?php echo date('Y-m-d', $revision->getDate()) ?></td>
                <td><?php echo $revision->getAuthor() ?></td>
                <td><?php echo $revision->getMessage() ?></td>
                <td class="last">&nbsp;</td>
              </tr>
              <?php
              $printed_line++;
            }
            ?>
          </table>
          <?php
            echo $form['path'];
          ?>
          <div class="actions-bar">
            <div class="actions">
              <input name="Show Diff" type="submit" class="button" value="<?php echo __('Show Diff') ?>" />
            </div>
            <div class="clear"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
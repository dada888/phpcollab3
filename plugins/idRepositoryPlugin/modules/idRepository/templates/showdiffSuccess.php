<?php slot('title', __('View Diff')) ?>
<?php slot('main_div_class', 'maindiff') ?>

<div class="block" id="block-tables">
<div class="content">
  <h2 class="title"><?php echo __('From revision %first_revision% to revision %second_revision%', array('%first_revision%' => $revision_first_id, '%second_revision%' => $revision_second_id)) ?></h2>
  <div class="inner">
    <table class="difftable">
      <tbody>
        <tr>
          <th class="first">&nbsp;</th>
          <th colspan="3"><?php echo urldecode($path); ?></th>
          <th class="last">&nbsp;</th>
        </tr>
        <?php foreach($blocks_left as $index_block => $block_left) : ?>
          <?php if($index_block > 0): ?>
                 <tr class="odd">
                  <td class="break">...</td>
                  <td class="break">...</td>
                  <td class="break">...</td>
                  <td class="break">...</td>
                  <td class="last">&nbsp;</td>
                 </tr>
          <?php endif ?>

          <?php foreach ($block_left->getLines() as $index_line => $line_left) : ?>
            <?php $line_right = $blocks_right[$index_block]->getLine($index_line); ?>
                 <tr class="odd">
                    <td<?php echo $line_left->isModifiedLine() ? " class=\"red\"" : ""; ?>><?php echo $line_left->getLineNumber() ?></td>
                    <td<?php echo $line_left->isModifiedLine() ? " class=\"red\"" : ""; ?>><?php echo $line_left ?></td>
                    <td<?php echo $line_right->isModifiedLine() ? " class=\"green\"" : ""; ?>><?php echo $line_right->getLineNumber() ?></td>
                    <td<?php echo $line_right->isModifiedLine() ? " class=\"green\"" : ""; ?>><?php echo $line_right ?></td>
                    <td></td>
                  </tr>
          <?php endforeach; ?>
        <?php endforeach;?>
      </tbody>
    </table>
    </div>
  </div>
</div>
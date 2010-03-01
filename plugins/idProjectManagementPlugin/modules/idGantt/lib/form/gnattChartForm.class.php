<?php

class gnattChartForm extends sfForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'resources_number' => new sfWidgetFormInput()
    ));

    $this->setValidators(array(
      'resources_number' => new sfValidatorNumber(array('required' => true), array('invalid' => 'Only numbers allowed', 'required' => 'the number of resources for this project is mandatory'))
    ));

    $this->widgetSchema->setNameFormat('gantt_data[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }

}

?>

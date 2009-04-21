<?php

/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * ShowDiffListForm
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 */

/**
 * ShowDiffListForm represents the form where two different revisions of a file can be choosed
 *
 * @package    phpCollab3
 * @subpackage idRepositoryPlugin
 * @author Filippo (p16) de Santis <fd@ideato.it>
 */

class ShowDiffListForm extends sfForm{

  private $choices = array();

  /**
   * Sets which are the possible chooses that should be axcepted by the formwhen it is validated.
   * The choices are the revision identifiers where that file has been involved.
   *
   * @param array $choices
   */
  private function setChoices($choices)
  {
    if (is_array($choices))
    {
      $choices_valid_array = array();
      foreach($choices as $key => $value)
      {
        $choices_valid_array[$value] = $key;
      }
      $this->choices = $choices_valid_array;
    }
    else
    {
      throw new Exception('setChoices nees an array as parameter');
    }
  }

  /**
   * Modifys the radio buttons representation associated with the choices of the revisions identifiers.
   * This modification is needed to represent the buttons in different lines of the table even if they
   * have the same id.
   *
   * @param mixed $widget
   * @param mixed $inputs
   * @return array
   */
  public static function radioFormatter($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
    {
      $rows[] =  array('input'=> $input['input'],  'label'=>$input['label']); // correct here
    }

    return $rows;
  }

  /**
   *  Main methods to configure the form, its widget and its validator
   */
  public function configure()
  {
    $this->setWidget('path', new sfWidgetFormInputHidden());
    $this->setWidget('revision_left', new sfWidgetFormSelectRadio(array('choices' =>$this->choices,'formatter'=> array('ShowDiffListForm','radioFormatter')), array('class' => 'checkbox')));
    $this->setWidget('revision_right', new sfWidgetFormSelectRadio(array('choices' =>$this->choices,'formatter'=> array('ShowDiffListForm','radioFormatter')), array('class' => 'checkbox')));

    $elementsNumber = count($this->choices);
    $left_choices = array();
    $right_choices = array();
    
    $count = 0;
    foreach ($this->choices as $key => $value)
    {
      if($count < $elementsNumber-1)
      {
        $left_choices[$key] = $value;
        $count++;
      }
    }
    $this->setValidator('revision_left', new sfValidatorChoice(
                                                              array('required' => true, 'choices' =>array_keys($left_choices)),
                                                              array(
                                                                    'invalid' => 'You should Select 2 values of 2 different revision',
                                                                    'required' => 'First diff revison required'
                                                                   )
                                                              )
                       );

    $count = 0;
    foreach ($this->choices as $key => $value)
    {
      if($count > 0)
      {
        $right_choices[$key] = $value;
      }
      $count++;
    }
    $this->setValidator('revision_right', new sfValidatorChoice(
                                                                array('required' => true, 'choices' =>array_keys($right_choices)),
                                                                array(
                                                                      'invalid' => 'You should Select 2 values of 2 different revision',
                                                                      'required' => 'Second diff revison required'
                                                                     )
                                                                )
                       );

    //TODO : $this->setValidator('path', new sfValidatorString());

    $this->validatorSchema->setPostValidator(
                          new sfValidatorSchemaCompare('revision_left', sfValidatorSchemaCompare::NOT_EQUAL, 'revision_right',
                                                        array('throw_global_error' => true),
                                                        array('invalid' => 'You must select different revision to visualize their differences [%left_field% - %right_field%].')
                                                      )
                                            );
  }

  /**
   * New constructor for this form to cope with the need of receving the array of the cpossible choices.
   *
   * @param array $choices
   * @see sfForm
   */
  public function __construct($choices, $defaults = array(), $options = array(), $CSRFSecret = null)
  {

    $this->setChoices($choices);
    parent::__construct($defaults = array(), $options = array(), $CSRFSecret = null);
  }

}
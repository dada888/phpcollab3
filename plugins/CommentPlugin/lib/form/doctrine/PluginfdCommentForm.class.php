<?php

abstract class PluginfdCommentForm extends BasefdCommentForm
{
  protected $model = '';
  protected $model_field = '';
  protected $model_field_value;
  protected $profile_configuration;

  public function __construct($model_object, $model_field,  $model_field_value, $object = null, $options = array(), $CSRFSecret = null)
  {
    if (is_null($model_object) ||
        is_null($model_field) ||
        is_null($model_field_value) ||
        !Doctrine::isValidModelClass(get_class($model_object)) || !Doctrine::getTable(get_class($model_object))->hasField($model_field))
    {
      throw new sfException(sprintf('The model (%s), model_field (%s) or model_field_value (%s) cannot be null or not defined on your schema.', get_class($model_object), $model_field, $model_field_value));
    }

    $this->model = get_class($model_object);
    $this->model_field = $model_field;
    $this->model_field_value = $model_field_value;
    $this->profile_configuration = sfConfig::get('sf_confing_comments_plugin_Profile', array());
    
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function getModel()
  {
    return $this->model;
  }

  public function getModelField()
  {
    return $this->model_field;
  }

  public function getModelFieldValue()
  {
    return $this->model_field_value;
  }

  public function setup()
  {
    parent::setup();

    $this->widgetSchema['title'] = new sfWidgetFormInput();
    $this->widgetSchema['model'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['model_field'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['model_field_value'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['body']->setAttribute('rows', 2);

    $this->setDefaults(array('model' => $this->model, 
                             'model_field' => $this->model_field,
                             'model_field_value' => $this->model_field_value,
                             'created_at' => date('Y-m-d H:i:s', time()),
                           ));
    
    $this->widgetSchema['profile_id'] = new sfWidgetFormInputHidden();

    $this->validatorSchema['model'] = new sfValidatorChoice(array('choices' => array($this->model)));
    $this->validatorSchema['model_field'] = new sfValidatorChoice(array('choices' => array($this->model_field)));
    $this->validatorSchema['title']->setOption('required', true);
    $this->validatorSchema['title']->setMessage('required', 'Title is mandatory');
    $this->validatorSchema['body']->setOption('required', true);
    $this->validatorSchema['body']->setMessage('required', 'Body is mandatory');

    if (isset($this->profile_configuration['enabled']) && $this->profile_configuration['enabled'])
    {
      $this->validatorSchema['profile_id'] = new sfValidatorDoctrineChoice(array('model' => $this->profile_configuration['class_name'], 'required' => true));
    }
  }
}
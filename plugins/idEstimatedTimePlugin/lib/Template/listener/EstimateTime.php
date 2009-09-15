<?php

class Doctrine_Template_Listener_EstimatedTime extends Doctrine_Record_Listener
{
    /**
     * Array of timestampable options
     *
     * @var string
     */
    protected $_options = array();

    /**
     * __construct
     *
     * @param string $options 
     * @return void
     */
    public function __construct(array $options)
    {
        $this->_options = $options;
    }

    /**
     * Set the created and updated Timestampable columns when a record is inserted
     *
     * @param Doctrine_Event $event
     * @return void
     */
    public function preInsert(Doctrine_Event $event)
    {
        if ( ! $this->_options['estimatedtime']['disabled']) {
            $createdName = $event->getInvoker()->getTable()->getFieldName($this->_options['estimatedtime']['name']);
            $modified = $event->getInvoker()->getModified();
            if ( ! isset($modified[$createdName])) {
                $event->getInvoker()->$createdName = $this->getFloat('estimatedtime');
            }
        }
    }

    /**
     * Gets the timestamp in the correct format based on the way the behavior is configured
     *
     * @param string $type 
     * @return void
     */
    public function getFloat($type)
    {
        $options = $this->_options[$type];

        if ($options['expression'] !== false && is_string($options['expression'])) {
            return new Doctrine_Expression($options['expression']);
        } else {
            return 0;
        }
    }
}
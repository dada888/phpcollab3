<?php

class EstimateTime extends Doctrine_Template
{
    /**
     * Array of Timestampable options
     *
     * @var string
     */
    protected $_options = array('estimatedtime' =>  array('name'          =>  'estimated_time',
                                                          'alias'         =>  null,
                                                          'type'          =>  'float',
                                                          'disabled'      =>  false,
                                                          'expression'    =>  false,
                                                          'options'       =>  array()));

    /**
     * __construct
     *
     * @param string $array 
     * @return void
     */
    public function __construct(array $options = array())
    {
        $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
    }

    /**
     * Set table definition for Timestampable behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
        if( ! $this->_options['estimatedtime']['disabled']) {
            $name = $this->_options['estimatedtime']['name'];
            if ($this->_options['estimatedtime']['alias']) {
                $name .= ' as ' . $this->_options['estimatedtime']['alias'];
            }
            $this->hasColumn($name, $this->_options['estimatedtime']['type'], null, $this->_options['estimatedtime']['options']);
        }

        $this->addListener(new Doctrine_Template_Listener_EstimatedTime($this->_options));
    }
}
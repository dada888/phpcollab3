<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

/**
 * Doctrine_Template_h2aEqualable
 *
 * Workaround for bug DC-329.
 * 
 * To use on the model used as refClass of an equal nest relation.
 *
 * Usage:
 * 
 * MyEqualNestRelationRefClassModel:
 *   actAs:
 *     h2aEqualable:
 *       fields: [ field_1 , field_2 ]
 * 
 * @package     Doctrine
 * @subpackage  Template
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 * @author      Pierrot Evrard <pierrotevrard@gmail.com>
 */
class Doctrine_Template_h2aEqualable extends Doctrine_Template
{
    /**
     * Array of fields name.
     *
     * @var string
     */
    protected $_options = array( 'fields' =>  array() );
    
    /**
     * Set table definition for h2aEqualable behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
	    $this->addListener( new Doctrine_Template_Listener_h2aEqualable( $this->_options ) );
    }
}
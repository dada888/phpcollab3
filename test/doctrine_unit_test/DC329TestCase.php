<?php

class Doctrine_Ticket_DC329_TestCase extends Doctrine_UnitTestCase
{
  protected $issues;
  
  public function prepareTables()
  {
    $this->tables[] = 'Issue';
    $this->tables[] = 'IssueReference';
    parent::prepareTables();
  }

  public function prepareData()
  {
    $issues = new Doctrine_Collection($this->connection->getTable('Issue'));

    $issues[0]->title = 'issue 1';
    $issues[1]->title = 'issue 2';
    $issues[2]->title = 'issue 3';
    $issues[3]->title = 'issue 4';
    $issues[4]->title = 'issue 5';

    $this->issues = $issues;
    $this->issues->save();

    $this->issues[0]->Issues[0] = $this->issues[1];
    $this->issues[0]->Issues[1] = $this->issues[2];
    $this->issues[0]->Issues[2] = $this->issues[3];
    $this->issues[0]->Issues[3] = $this->issues[4];
    $this->issues[0]->save();
  }


  public function testSavingSelfRelations()
  {
    $issue_id1 = Doctrine::getTable('Issue')->findOneBy('id', '1');
    $new_issue = new Issue();
    $new_issue->title = 'new_issue';
    try
    {
      $issue_id1->Issues[4] = $new_issue;
      $issue_id1->save();
      $this->pass('issues relation saved');
    }
    catch(Exception $e)
    {
      $this->fail('saving relation failed: '.$e->getMessage());
    }

    $issue_id1->refresh();
    $issue_id1->refreshRelated();
    $this->assertEqual($issue_id1->Issues->count(), 5);
    $this->assertEqual($issue_id1->Issues[0]->id, 2);
    $this->assertEqual($issue_id1->Issues[1]->id, 3);
    $this->assertEqual($issue_id1->Issues[2]->id, 4);
    $this->assertEqual($issue_id1->Issues[3]->id, 5);
    $this->assertEqual($issue_id1->Issues[4]->id, 6);

    $issue_id1->free(true);

    $issue_id2 = Doctrine::getTable('Issue')->findOneBy('id', '2');
    $new_issue = new Issue();
    $new_issue->title = 'new_issue';
    try
    {
      $issue_id2->Issues[4] = $new_issue;
      $issue_id2->save();
      $this->pass('issues relation saved');
    }
    catch(Exception $e)
    {
      $this->fail('saving relation failed: '.$e->getMessage());
    }

    $issue_id2->refresh();
    $issue_id2->refreshRelated();
    $this->assertEqual($issue_id2->Issues->count(), 5);
    $this->assertEqual($issue_id2->Issues[0]->id, 1);
    $this->assertEqual($issue_id2->Issues[1]->id, 2);
    $this->assertEqual($issue_id2->Issues[2]->id, 3);
    $this->assertEqual($issue_id2->Issues[3]->id, 4);
    $this->assertEqual($issue_id2->Issues[4]->id, 7);

    $issue_id1 = Doctrine::getTable('Issue')->findOneBy('id', '1');
    try
    {
      $issue_id1->Issues[0] = $issue_id2;
      $issue_id1->save();
      $this->pass('issues relation saved');
    }
    catch(Exception $e)
    {
      $this->fail('saving relation failed: '.$e->getMessage());
    }

    $issue_id1->refresh();
    $issue_id1->refreshRelated();
    $this->assertEqual($issue_id1->Issues->count(), 5);
    $this->assertEqual($issue_id1->Issues[0]->id, 2);
    $this->assertEqual($issue_id1->Issues[1]->id, 3);
    $this->assertEqual($issue_id1->Issues[2]->id, 4);
    $this->assertEqual($issue_id1->Issues[3]->id, 5);
    $this->assertEqual($issue_id1->Issues[4]->id, 6);

  }


  public function testManyToManySelfReferencingRalation()
  {
    $this->issues[1]->refresh();
    $this->issues[1]->refreshRelated();
    $this->issues[1]->Issues[0] = $this->issues[0];
    $this->issues[1]->Issues[1] = $this->issues[2];
    $this->issues[1]->Issues[2] = $this->issues[3];
    $this->issues[1]->Issues[3] = $this->issues[4];

    try
    {
        $this->issues[1]->save();
        $this->pass('issue multi related saved');
    }
    catch(Exception $e)
    {
        $t->fail('saving multi relations failed: '.$e->getMessage());
    }

    $this->issues[0]->refresh();
    $this->issues[0]->refreshRelated();
    $this->assertEqual($this->issues[0]->Issues->count(), 4);
    $this->assertEqual($this->issues[0]->Issues[0]->id, 2);
    $this->assertEqual($this->issues[0]->Issues[1]->id, 3);
    $this->assertEqual($this->issues[0]->Issues[2]->id, 4);
    $this->assertEqual($this->issues[0]->Issues[3]->id, 5);


    /*the second issue has multiple relation only with the issue with id 1 => $this->issues[0] */
    $this->issues[1]->refresh();
    $this->issues[1]->refreshRelated();
    $this->assertEqual($this->issues[1]->Issues->count(), 4);
    $this->assertEqual($this->issues[1]->Issues[0]->id, 1);
    $this->assertEqual($this->issues[1]->Issues[0]->id, 3);
    $this->assertEqual($this->issues[1]->Issues[0]->id, 4);
    $this->assertEqual($this->issues[1]->Issues[0]->id, 5);

  }
}

class Issue extends Doctrine_Record
{

  public function setTableDefinition()
  {
    $this->setTableName('issue');
    $this->hasColumn('id', 'integer', null, array(
                        'type' => 'integer',
                        'primary' => true,
                        'autoincrement' => true,
    ));
    $this->hasColumn('title', 'string', 256, array(
                        'type' => 'string',
                        'length' => '256',
    ));
  }
  
  public function setUp()
  {
    $this->hasMany('Issue as Issues', array(
                   'refClass' => 'IssueReference',
                   'local' => 'issue1',
                   'foreign' => 'issue2',
                   'equal' => true));
  }
}

class IssueReference extends Doctrine_Record
{
  public function setTableDefinition()
  {
    $this->setTableName('issue_reference');
    $this->hasColumn('issue1', 'integer', null, array(
                        'type' => 'integer',
                        'primary' => true,
    ));
    $this->hasColumn('issue2', 'integer', null, array(
                        'type' => 'integer',
                        'primary' => true,
    ));

    $this->option('charset', 'utf8');
  }
  
  public function setUp()
  { }
}

<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * idCommentActions actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 */

/**
 * idComment actions.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Modules
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 */
class idCommentActions extends sfActions
{
  /**
   * Returns a partial with the issue comment list given the issue id
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeIndex(sfWebRequest $request)
  {
    $issue = Doctrine::getTable('Issue')->find(array($request->getParameter('issue_id')));
    
    if (is_null($issue) || !$this->getUser()->isMyProjectByIssue($issue))
    {
      return $this->renderPartial('idComment/invalid');
    }

    return $this->renderPartial('idComment/comments_list', array('issue' => $issue));
  }

  /**
   * Forwords to 404 page
   *
   * @param <type> $request
   */
  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
    $this->form = new CommentForm();
  }

  /**
   * Returns the list of the comment plus the new one or the old list with an error message.
   *
   * @param sfWebRequest $request
   * @return string
   */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->getRequest()->isXmlHttpRequest() || $request->isMethod('post'));
    $form_parameters = $request->getParameter('comment');

    $issue = Doctrine::getTable('Issue')->find(array($form_parameters['issue_id']));

    if (is_null($issue) || !$this->getUser()->isMyProjectByIssue($issue))
    {
      return $this->renderPartial('idComment/invalid');
    }
    
    $this->form = new CommentForm();
    $this->form->setDefault('profile_id', $this->getUser()->getProfile()->getId());
    $this->form->setDefault('created_at', date('Y-m-d H:i:s', time()));

    return $this->processForm($request, $this->form, $issue);
  }

  /**
   * Forwords to 404 page
   *
   * @param <type> $request
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404();
    $this->forward404Unless($comment = Doctrine::getTable('Comment')->find(array($request->getParameter('id'))), sprintf('Object comment does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new CommentForm($comment);
  }

  /**
   * Forwords to 404 page
   *
   * @param <type> $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404();
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($comment = Doctrine::getTable('Comment')->find(array($request->getParameter('id'))), sprintf('Object comment does not exist (%s).', array($request->getParameter('id'))));
    $this->form = new CommentForm($comment);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  /**
   * Forwords to 404 page
   *
   * @param <type> $request
   */
  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404();
    $request->checkCSRFProtection();

    $this->forward404Unless($comment = Doctrine::getTable('Comment')->find(array($request->getParameter('id'))), sprintf('Object comment does not exist (%s).', array($request->getParameter('id'))));
    $comment->delete();

    $this->redirect('idComment/index');
  }

  /**
   * Given the form parameters validates the form compiled and return a partial with the list of the updated comments or a partial of the old list and an error message.
   *
   * @param sfWebRequest $request
   * @param sfForm $form
   * @param Issue $issue
   * @return string
   */
  protected function processForm(sfWebRequest $request, sfForm $form, Issue $issue)
  {
    $form_parameters = $request->getParameter($form->getName());
    $form_parameters['created_at'] = date('Y-m-d H:i:s', time());
    $form_parameters['profile_id'] = $this->getUser()->getProfile()->getId();

    $form->bind($form_parameters);

    if ($form->isValid())
    {
      $comment = $form->save();

      return $this->renderPartial('idComment/comments_list', array('issue' => $comment->getIssue()));
    }
    
    return $this->renderPartial('idComment/comments_list', array('issue' => $issue, 'global_errors' => $form->getGlobalErrors(), 'body_errors' => $form['body']->getError()));
  }
}

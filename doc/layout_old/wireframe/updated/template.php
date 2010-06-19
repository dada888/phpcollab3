<? include ('header.php'); ?>
      <div class="span-23" id="content">
        <div class="span-full">
          <div class="title"><span>Add Time</span></div>
          <div class="span-full">
            <div class="highlight last-row">
              <div class="span-half">
                <div class="span-full">
                  <label><strong class="red">Name</strong></label><br />

                  <select class="dropName span-8">
                    <option>Adam P</option>
                    <option>James f</option>
                    <option>Paul S</option>
                  </select>
                </div>
                <div class="span-full">
                  <label><strong class="red">Project</strong></label><br />

                  <select name="select" class="dropMonth span-8">
                    <option></option>
                    <option>ABC</option>
                    <option>ACME</option>
                    <option>Internal</option>
                  </select>
                </div>
                <div class="span-full">
                  <label> <strong class="red">Description</strong></label><br />

                  <input type="text" class="inputSummary span-8" value="" />
                </div>
              </div>
              <div class="span-half">
                <div class="span-full">
                  <label><strong class="red">Date</strong></label><br />

                  <img src="images/temp-cal.jpg" alt="Cal" width="108" height="19" /> </div>
                <div class="span-full">
                  <label> <span class="red"><strong>How long did you take?</strong></span></label><br />

                  <input type="text" class="inputHours span-8" value="" />
                </div>
              </div>
              <div class="right">
              <a href="#" class="button block-red medium-round">Cancel</a>
              <a href="#" class="button block-green medium-round">Save</a>
              </div>
            </div>
            <div class="notice clear">To be cleaned up<br />
            Open in a modal window</div>
          </div>
          <div class="title"><span>Time</span><a href="#" class="button block-green medium-round">Add</a> </div>
          <div class="span-full">
            <div class="menu">
              <div class="span-3">Name</div>
              <div class="span-9">Description</div>
              <div class="span-3">Date</div>
              <div class="span-2">Time</div>
              <div class="span-4 right last"><span>Project</span></div>
            </div>
            <ul class="action time">
              <li class="icon-time">
                <ul>
                  <li class="span-3"><a href="person.html">Adam P.</a> </li>
                  <li class="span-9"> <strong>Updated something</strong></li>
                  <li class="span-3">June 14th</li>
                  <li class="span-2">45min</li>
                  <li class="right"><a href="#project">The New Acme Project</a></li>
                  <li class="edit-delete"> <a href="http://dev.mapleflow.com/Dev-Addressbook-MVC/index.php/admin/update/138">Edit </a> &nbsp;&nbsp;<a href="http://dev.mapleflow.com/Dev-Addressbook-MVC/index.php/admin/delete/138">Delete</a> </li>
                </ul>
              </li>
              <li class="icon-time no-border">
                <ul>
                  <li class="span-3"><a href="person.html">Adam P.</a> </li>
                  <li class="span-9"> <strong>Updated something</strong></li>
                  <li class="span-3">June 14th</li>
                  <li class="span-2">45min</li>
                  <li class="right"><a href="#project">The New Acme Project</a></li>
                  <li class="edit-delete"> <a href="http://dev.mapleflow.com/Dev-Addressbook-MVC/index.php/admin/update/138">Edit </a> &nbsp;&nbsp;<a href="http://dev.mapleflow.com/Dev-Addressbook-MVC/index.php/admin/delete/138">Delete</a> </li>
                </ul>
              </li>
            </ul>
            <div class="notice clear">Time under projects is to be sorted by date, time under the users time sheet can be sorted by project.</div>
          </div>
          <div class="title"><span>Files</span><a href="#" class="button block-green medium-round">Add</a> </div>
          <div class="span-full">
            <div class="menu">
              <div class="span-3">Name</div>
              <div class="span-15">Description</div>
              <div class="span-4 right last"><span>Project</span></div>
            </div>
            <ul class="action">
              <li class="icon-grey">
                <ul>
                  <li class="span-3"><span class="quiet">Trivial</span></li>
                  <li class="span-15">Imperdiet ipsum ante vel elit. <span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin">June 18th</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-grey no-border">
                <ul>
                  <li class="span-3"><span class="quiet">On Hold</span> </li>
                  <li class="span-15"> Iimperdiet ipsum ante vel elit. sem lorem tincidunt nunc. <span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin" >May 2nd</a></div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="title"><span>Activity</span></div>
          <div class="span-full">
            <div class="menu">
              <div class="span-3">Name</div>
              <div class="span-15">Description</div>
              <div class="span-4 right last"><span>Project</span></div>
            </div>
            <ul class="action">
              <li class="icon-updated">
                <ul>
                  <li class="span-3"><a href="#profile">Adam P</a></li>
                  <li class="span-15">Updated <a href="#ticket">#567 Ticket Title</a></li>
                  <li class="span-4 right last">
                    <div><a href="#project-link">Project Name</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-add">
                <ul>
                  <li class="span-3"><a href="#profile">James M</a></li>
                  <li class="span-15">Created a new ticket <a href="#ticket">#345 Ticket Title</a></li>
                  <li class="span-4 right last">
                    <div><a href="#project-link">Project Name</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-comment">
                <ul>
                  <li class="span-3"><a href="person.html" class="name">James M</a></li>
                  <li class="span-15">Commented on <a href="#">Lets talk about the future</a></li>
                  <li class="span-4 right last">
                    <div><a href="#project-link" class="project-name">ACME Project</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-discussion">
                <ul>
                  <li class="span-3"><a href="person.html" class="name">Samantha T</a></li>
                  <li class="span-15">Started the Discussion: <a href="#">Set up production database</a></li>
                  <li class="span-4 right last">
                    <div><a href="#project-link" class="project-name">ACME Project</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-repo">
                <ul>
                  <li class="span-3"><a href="#profile">Simon H</a></li>
                  <li class="span-15"><a href="#repo">Repo Name</a> repository has been updated</li>
                  <li class="span-4 right last">
                    <div><a href="#project-link">Project Name</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-red">
                <ul>
                  <li class="span-3"><strong class="red">Critical.</strong></li>
                  <li class="span-15">imperdiet ipsum ante vel elit. <span class="quiet">for</span> <a href="#">ABC Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin" >Yesterday</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-red">
                <ul>
                  <li class="span-3"><strong class="red">High.</strong></li>
                  <li class="span-15">imperdiet ipsum ante vel elit. <span class="quiet">for</span> <a href="#">Internal Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin">June 18th</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-green">
                <ul>
                  <li class="span-3"><strong>Normal.</strong></li>
                  <li class="span-15">Ssed mollis  dignissim, sem lorem tincidunt nunc, et imperdiet ipsumr <span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin" >June 19th</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-green">
                <ul>
                  <li class="span-3">Low.</li>
                  <li class="span-15">Imperdiet ipsum ante vel elit. <strong> </strong><span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin">June 18th</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-grey">
                <ul>
                  <li class="span-3"><span class="quiet">Trivial</span></li>
                  <li class="span-15">Imperdiet ipsum ante vel elit. <span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin">June 18th</a></div>
                  </li>
                </ul>
              </li>
              <li class="icon-grey no-border">
                <ul>
                  <li class="span-3"><span class="quiet">On Hold</span> </li>
                  <li class="span-15"> Iimperdiet ipsum ante vel elit. sem lorem tincidunt nunc. <span class="quiet">for</span> <a href="#">Acme Project</a></li>
                  <li class="span-4 last right">
                    <div><a href="#project-dashboard-admin" >May 2nd</a></div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="span-full bumper-bottom">
            <div class="title"><span>Tickets</span><a href="#" class="button block-green medium-round">Add</a> </div>
            <div class="menu bumper-top">
              <div class="span-18">Status is <em>Open,</em> Any Priority, Any Category, and Any Opener</div>
            </div>
            <div class="tickets">
              <div class="issue odd" >
                <h3><a href="project-ticket-open.html">#1 This is an issue</a></h3>
                <span class="meta"> <a href="#bug">Bug</a> <abbr title="2010-04-05 16:57:45 -0600">5 hours old</abbr></span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/1/comments" class="status block-green">Open</a></li>
                  <li class="priority critical">Critical</li>
                </ul>
                <ul class="people">
                  <li><span>Assigned to</span> <strong>Adam P</strong></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
              <div class="issue even" >
                <h3><a href="project-ticket-open.html">#4 What happens?</a></h3>
                <span class="meta"><abbr title="2010-04-05 17:00:17 -0600">5 hours old</abbr> </span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/6/comments" class="status block-green"><span>Open</span></a></li>
                  <li class="priority critical">Critical</li>
                </ul>
                <ul class="people">
                  <li><span>Assigned to</span> <strong>Adam P</strong></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
              <div class="issue odd">
                <h3><a href="project-ticket-open.html">#7 Another Issue</a></h3>
                <span class="meta"> <a href="#Cosmetic">Cosmetic</a><abbr title="2010-04-05 16:58:15 -0600">5 hours old</abbr> </span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/2/comments" class="status block-green">REOPENED</a></li>
                  <li class="priority high">High</li>
                </ul>
                <ul class="people">
                  <li><span>Currently Unassigned</span></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
              <div class="issue even" >
                <h3><a href="project-ticket-open.html">#8 Issue</a></h3>
                <span class="meta"> <a href="#usability">Usability</a> <abbr title="2010-04-05 16:58:26 -0600">5 hours old</abbr> </span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/3/comments" class="status block-green">Open</a></li>
                  <li class="priority normal">Normal</li>
                </ul>
                <ul class="people">
                  <li><span>Accepted by</span> <strong>James H.</strong></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
              <div class="issue odd" >
                <h3><a href="project-ticket-open.html">#456 Another</a></h3>
                <span class="meta"> <a href="#working">Working as Designed</a><abbr title="2010-04-05 16:58:35 -0600"> 5 hours old</abbr> </span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/4/comments" class="status block-gray">Closed</a></li>
                  <li class="priority low">Low</li>
                </ul>
                <ul class="people">
                  <li><span>Currently Unassigned</span></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
              <div class="issue even">
                <h3><a href="project-ticket-open.html">#5856 one more</a></h3>
                <span class="meta"> <a href="#issue">Issue</a> 5 <abbr title="2010-04-05 16:58:51 -0600"> hours old</abbr> </span>
                <ul class="state">
                  <li><a href="/projects/6131/issues/5/comments" class="status block-yellow">Resolved</a></li>
                  <li class="priority trivial">Trivial</li>
                </ul>
                <ul class="people">
                  <li><span>Currently Unassigned</span></li>
                  <li><span>Opened by</span> <strong>Adam P</strong></li>
                </ul>
              </div>
            </div>
            <!-- --> 
          </div>
        </div>
        <div class="span-full">
          <div class="title"><span>Projects</span><a href="#" class="button block-green medium-round">Add</a> </div>
          <div class="span-full" id="project">
            <div class="span-full odd">
              <h3>Redesign  Project <span>for <a href="#">Adam Company</a></span></h3>
              <div class="span-4">Status:<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Assigned to me
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Total
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full even">
              <h3>Print Design <span>for <a href="#">ACME Co.</a></span></h3>
              <div class="span-4">Status:<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Assigned to me
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Total
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full odd">
              <h3>Setup Company Wiki <span>for <a href="#">ACME Co.</a></span></h3>
              <div class="span-4">Status:<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Assigned to me
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Totla
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full bumper-top">
              <div class="title"> Inactive Projects</div>
            </div>
            <div class="span-full odd">
              <div class="span-18">
                <h3>Setup Company Wiki <span>for <a href="#">ACME Co.</a></span></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full even">
              <div class="span-18">
                <h3>Setup Company Wiki <span>for <a href="#">ACME Co.</a></span></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full odd  bumper-bottom">
              <div class="span-18">
                <h3>Setup Company Wiki <span>for <a href="#">ACME Co.</a></span></h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
          </div>
        </div>
        <div class="span-full">
          <div class="title"><span>Goals</span><a href="#" class="button block-green medium-round">Add</a> </div>
          <div class="span-full" id="milestone">
            <div class="span-full odd">
              <h3 class="critical"><em>Version 2.0</em></h3>
              <p>The next version</p>
              <div class="span-4">Progress<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Tasks
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Due
                <h3>3 Days Late</h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full even">
              <h3 class="high"><em>Coming Up Release</em></h3>
              <p>Follow up to version 2.0</p>
              <div class="span-4">Progress<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Tasks
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Due
                <h3>in 4 Days</h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
            <div class="span-full odd bumper-bottom">
              <h3><em>Future Release</em></h3>
              <p>Future release plans, no hurry.</p>
              <div class="span-4">Progress<br />
                <h3> 78% <span>Completed</span></h3>
              </div>
              <div class="span-7">Tasks
                <h3><a href="#">250 <span>Open</span></a> <a href="#">30 <span>Resolved</span></a></h3>
              </div>
              <div class="span-7">Due
                <h3>June 26th 2010</h3>
              </div>
              <div class="right"> <a href="#" class="button block-gray medium-round">Create a Task</a> </div>
            </div>
          </div>
        </div>
        <div class="span-full">
          <div class="title"><span>Code Revisions</span><a href="#" class="button block-green medium-round">Add</a> </div>
          <div class="span-full">
            <div class="menu">
              <div class="span-3">Name</div>
              <div class="span-15">Description</div>
              <div class="span-4 right last"><span>Project</span></div>
            </div>
            <ul class="action">
              <li class="icon-repo">
                <div class="span-half"><strong>Commit:</strong> <a href="#">1359</a> by <strong>Adam P</strong> on <strong>June 23rd 2009</strong> @ <strong>3:36pm</strong></div>
                <div class="right"><a href="#">ACME Redesign Project</a></div>
                <p><a href="#">#567</a> Fixed email template email template email template email template email template email template email template email template email template </p>
              </li>
              <li class="icon-repo">
                <div class="span-half"><strong>Commit:</strong> <a href="#">1359</a> by <strong>Adam P</strong> on <strong>June 23rd 2009</strong> @ <strong>3:36pm</strong></div>
                <div class="right"><a href="#">ACME Redesign Project</a></div>
                <p><a href="#">#567</a> Fixed email template email template email template email template email template email template email template email template email template </p>
              </li>
              <li class="icon-repo">
                <div class="span-half"><strong>Commit:</strong> <a href="#">1359</a> by <strong>Adam P</strong> on <strong>June 23rd 2009</strong> @ <strong>3:36pm</strong></div>
                <div class="right"><a href="#">ACME Redesign Project</a></div>
                <p><a href="#">#567</a> Fixed email template email template email template email template email template email template email template email template email template </p>
              </li>
              <li class="icon-repo no-border">
                <div class="span-half"><strong>Commit:</strong> <a href="#">1359</a> by <strong>Adam P</strong> on <strong>June 23rd 2009</strong> @ <strong>3:36pm</strong></div>
                <div class="right"><a href="#">ACME Redesign Project</a></div>
                <p><a href="#">#567</a> Fixed email template email template email template email template email template email template email template email template email template </p>
              </li>
            </ul>
          </div>
        </div>
        <div class="span-full pagenation">
          <ul>
            <li><a href="#"><img src="images/pagination-left.png" alt="Previous" title="Previous"/></a></li>
            <li><a href="#" class="current_page">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#"><img src="images/pagination-right.png" alt="Next" title="Next"/></a></li>
          </ul>
        </div>
        <? //include('content.php') ?>
      </div><!-- #content -->
   <? include ('sidebar.php'); ?>
   <? include ('footer.php'); ?>  


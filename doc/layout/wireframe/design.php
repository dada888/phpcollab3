<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Addressbook Rebuild</title>
<link href="lib/blueprint/screen.css" rel="stylesheet" type="text/css" />
<link href="custom.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="lib/blueprint/print.css" type="text/css" media="print" />
<!--[if IE]><link rel="stylesheet" href="lib/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
</head>
<body>
<div class="container">
  <div class="column span-24 header last">
    <div class="column span-1 headerCapLeft"></div>
    <div class="column span-11 logo"><a href="index.php"><img src="images/logo.png" width="304" height="76" alt="Addressbook" /></a></div>
    <div class="column span-11 utility">
      <div class="column span-11 utility-nav last"><a href="#" class="utilLogin">Login</a> <a href="#" class="utilLogin">Profile</a> <a href="#" class="utilSettings">Settings</a> <a href="#" class="utilAbout">About</a> <a href="#" class="utilHelp">Help</a></div>
      <div id="header-search" class="search-box column span-11 utility-search last right">
        <form id="main-search-form" action="index.php?page=list" method="post">
          <div class="search-button">
            <input class="submit" value="" type="submit">
          </div>
          <div class="center">
            <input class="search placeholder" name="q" title="Reference or Keyword" value="" type="text">
          </div>
          <div class="left"></div>
        </form>
      </div>
    </div>
    <div class="column span-1 headerCapRight last"></div>
  </div>
  <div class="column span-22 append-1 prepend-1 last">
    <div class="column span-13 navigation">
      <ul>
        <li class="current"><a href="#">Home</a></li>
        <li class="page"><a href="#">Groups</a></li>
        <li class="page"><a href="#">Export</a></li>
        <li class="page"><a href="#">Maps</a></li>
      </ul>
    </div>
    <div class="column span-9 quickNavigation last">
      <ul>
        <li><a href="#" class="current" id="addIcon">Add Contact</a></li>
        <li><a href="#" class="page" id="groupIcon">Groups</a></li>
      </ul>
    </div>
    <div class="column span-20 prepend-1 append-1 content last">
      <div class="column span-20 last content-section">
        <a class="button" href="#" onclick="this.blur();"><span><img src="images/icons/16-remove.png" width="16" height="16" alt="Delete" />CANCEL</span></a> 
          <a class="button" href="#" onclick="this.blur();"><span><img src="images/icons/16-add.png" width="16" height="16" alt="Delete" />ADD</span></a> <br />
<div class="save">
            <input type="submit" value="SAVE" class="submit"/>
          </div>
<br />

      </div>
      <!--
	START Content ---------------->

    
      <div class="column span-20 last content-section">
        <h6>Home Page</h6>
        <hr />
        <div class="column span-20 right menu-row last">
          <div class="column span-12  right">&nbsp;</div>
          <div class="column span-1 menu-actions"><a href="#"><img src="images/icons/20-menu-grid.png" width="21" height="20" alt="Grid View" /></a></div>
          <div class="column span-1 menu-actions"><a href="#"><img src="images/icons/20-menu-list.png" width="21" height="20" alt="List View" /></a></div>
          <div class="column span-6 last">
            <select onchange="location = this.options[this.selectedIndex].value;" name="groupe">
              <option>View a Group</option>
              <option value="template.php?page=list&amp;group=18">Teachers</option>
              <option value="template.php?page=list&amp;group=3">Friends</option>
              <option value="template.php?page=list&amp;group=4">Family</option>
              <option value="template.php?page=list&amp;group=5">Co-Workers</option>
              <option value="template.php?page=list&amp;group=6">nForm</option>
              <option value="template.php?page=list&amp;group=7">Alberta Education</option>
              <option value="template.php?page=list&amp;group=1">UnListed</option>
              <option value="template.php?page=list&amp;group=19">United Cycle</option>
              <option value="template.php?page=list&amp;group=22">Alberta College</option>
              <option value="template.php?page=list&amp;group=24">Clients</option>
              <option value="template.php?page=list&amp;group=25">General Contacts</option>
              <option value="template.php?page=list&amp;group=27">Multi Media Firms</option>
              <option value="template.php?page=list&amp;group=29">Biking</option>
              <option value="template.php?page=list&amp;group=31">Print Production</option>
              <option value="template.php?page=list&amp;group=32">Young Life</option>
            </select>
          </div>
        </div>
        <div class="column span-20 menu last">
          <div class="column span-2">&nbsp;</div>
          <div class="column span-4">Name</div>
          <div class="column span-4">Phone</div>
          <div class="column span-6">Email</div>
        </div>
        <div class="column span-19">
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4 last actions"><img src="images/icons/14-edit.png" width="14" height="14" alt="Edit" /> Edit <img src="images/icons/14-delete.png" width="14" height="14" alt="Delete" /> Delete</div>
            </div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4 last">Adam Patterson</div>
            </div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth-grey.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home-grey.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth-grey.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail-grey.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-19 data-row last">
            <div class="column span-2"><img src="images/icons/48-photo.png" width="48" height="48" alt="Photo" /></div>
            <div class="column span-4">Adam Patterson</div>
            <div class="column span-4"><strong>H</strong> (780) 455-6599<br />
              <strong>W</strong> (780) 455-6599 </div>
            <div class="column span-6">adamapatterson@gmail.com<br />
              adam@studiolounge.net </div>
            <div class="column span-3 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
        </div>
        <div class="column span-1 alphabetical last">
          <ul>
            <li><a href="index.php?page=list">all</a></li>
            <li><a href="index.php?page=list&alphabet=a">a</a></li>
            <li><a href="index.php?page=list&alphabet=b">b</a></li>
            <li><a href="index.php?page=list&alphabet=c">c</a></li>
            <li><a href="index.php?page=list&alphabet=d">d</a></li>
            <li><a href="index.php?page=list&alphabet=e">e</a></li>
            <li><a href="index.php?page=list&alphabet=f">f</a></li>
            <li><a href="index.php?page=list&alphabet=g">g</a></li>
            <li><a href="index.php?page=list&alphabet=h">h</a></li>
            <li><a href="index.php?page=list&alphabet=i">i</a></li>
            <li><a href="index.php?page=list&alphabet=j">j</a></li>
            <li><a href="index.php?page=list&alphabet=k">k</a></li>
            <li><a href="index.php?page=list&alphabet=l">l</a></li>
            <li><a href="index.php?page=list&alphabet=m">m</a></li>
            <li><a href="index.php?page=list&alphabet=n">n</a></li>
            <li><a href="index.php?page=list&alphabet=o">o</a></li>
            <li><a href="index.php?page=list&alphabet=p">p</a></li>
            <li><a href="index.php?page=list&alphabet=q">q</a></li>
            <li><a href="index.php?page=list&alphabet=r">r</a></li>
            <li><a href="index.php?page=list&alphabet=s">s</a></li>
            <li><a href="index.php?page=list&alphabet=t">t</a></li>
            <li><a href="index.php?page=list&alphabet=u">u</a></li>
            <li><a href="index.php?page=list&alphabet=v">v</a></li>
            <li><a href="index.php?page=list&alphabet=w">w</a></li>
            <li><a href="index.php?page=list&alphabet=x">x</a></li>
            <li><a href="index.php?page=list&alphabet=y">y</a></li>
            <li><a href="index.php?page=list&alphabet=z">z</a>
          </ul>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h2>Adam Patterson <span><a href="#">Edit</a> <a href="#">Delete</a></span></h2>
        <div class="column span-19">
          <div class="column span-19 data-row last">
            <div class="column span-4 append-1">
              <div class="column span-4 actions single last"> <img src="images/icons/48-photo.png" width="150" alt="Photo" /> </div>
              <div class="column span-4 actions right last"><img src="images/icons/20-earth.png" width="20" height="20" alt="Earth" /><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-home.png" width="20" height="20" alt="Home" /><img src="images/icons/20-addressbook.png" width="20" height="20" alt="Addressbook" /></div>
            </div>
            <div class="column span-14 last">
              <div class="column span-5"><strong>Address</strong></div>
              <div class="column span-9 last">adamapatterson@gmail.com<br />
                adam@studiolounge.net </div>
            </div>
            <div class="column span-14 last">
              <div class="column span-5"><strong>Contact</strong></div>
              <div class="column span-9 last">adamapatterson@gmail.com<br />
                adam@studiolounge.net <br />
                <br />
                <br />
                <br />
              </div>
            </div>
            <div class="column span-14 last">
              <div class="column span-5"><strong>Other Stuff</strong><br />
                <br />
                <br />
                <br />
                <br />
                <br />
              </div>
              <div class="column span-9 last">adamapatterson@gmail.com<br />
                adam@studiolounge.net <br />
                <br />
                <br />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Add Contact</h6>
        <hr />
        <div class="error rounded"> You must include a first name. </div>
        <div class="column span-10">
          <h6>Personal Info:</h6>
          <hr />
          <div class="column span-10 form-row last">
            <div class="red"><strong>First Name</strong></div>
            <div class="column span-7 ">
              <input type="text" class="text" />
            </div>
            <div class="column span-1 actions last"><img src="images/icons/20-x.png" width="20" height="20" alt="Wrong" /></div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Last Name</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Password</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Birthdate</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
        </div>
        <div class="column span-10 last">
          <h6>Location:</h6>
          <hr />
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Address</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Address 2</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Postal Code</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Province</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 form-row small right"><strong>Country</strong></div>
            <div class="column span-7 last">
              <input type="text" class="text" />
            </div>
          </div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <div class="column span-10">
          <h6>Contact Info:</h6>
          <hr />
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>E-Mail</strong></div>
            <div class="column span-7 small-radio">
              <input type="text" class="text" />
              <input type="radio" name="example"/>
              Home
              <input type="radio" name="example"/>
              Work
              <input type="radio" name="example"/>
              Other</div>
            <div class="column span-1 actions last"> <a href="#"><img src="images/icons/20-add-ball.png" width="20" height="20" alt="Add" /></a></div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>E-Mail</strong></div>
            <div class="column span-7 small-radio">
              <input type="text" class="text" />
              <input type="radio" name="example"/>
              Home
              <input type="radio" name="example"/>
              Work
              <input type="radio" name="example"/>
              Other</div>
            <div class="column span-1 actions last"><a href="#"><img src="images/icons/20-remove.png" width="20" height="20" alt="Remove" /></a></div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Phone</strong></div>
            <div class="column span-7 small-radio">
              <input type="text" class="text" />
              <input type="radio" name="example"/>
              Home
              <input type="radio" name="example"/>
              Work
              <input type="radio" name="example"/>
              Cell
              <input type="radio" name="example"/>
              Other</div>
            <div class="column span-1 actions last"> <a href="#"><img src="images/icons/20-add-ball.png" width="20" height="20" alt="Add" /></a></div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Phone</strong></div>
            <div class="column span-7 small-radio">
              <input type="text" class="text" />
              <input type="radio" name="example"/>
              Home
              <input type="radio" name="example"/>
              Work
              <input type="radio" name="example"/>
              Cell
              <input type="radio" name="example"/>
              Other </div>
            <div class="column span-1 actions last"><a href="#"><img src="images/icons/20-remove.png" width="20" height="20" alt="Remove" /></a></div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Website</strong></div>
            <div class="column span-7 ">
              <input type="text" class="text" />
            </div>
            <div class="column span-1 actions last"> <img src="images/icons/20-check.png" width="20" height="20" alt="Check" /> </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>IM</strong></div>
            <div class="column span-4 last">
              <input type="text" class="text" />
            </div>
            <div class="column span-3 last">
              <select>
                <option>MSN</option>
                <option>Google Talk</option>
                <option>ICD</option>
              </select>
            </div>
          </div>
        </div>
        <div class="column span-10 last">
          <h6>Misc Info:</h6>
          <hr />
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Notes</strong></div>
            <div class="column span-7 last">
              <textarea cols="200" rows="5" class="text"></textarea>
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="column span-2 right small"><strong>Photo</strong></div>
            <div class="column span-8 last">
              <input type="file" name="profile" id="profile" class="text" />
            </div>
          </div>
          <div class="column span-10 form-row last">
            <div class="notice rounded"><strong>Full</strong> - Type of access<br />
              <strong>Group</strong> - Type of access<br />
              <strong>Single</strong> - Type  of access</div>
            <fieldset>
              <div class="column span-2 right small">
                <label>Access</label>
              </div>
              <div class="column span-6 last">
                <input type="radio" name="example"/>
                Full<br/>
                <input type="radio" name="example"/>
                Group<br/>
                <input type="radio" name="example"/>
                Single<br/>
              </div>
            </fieldset>
          </div>
          <div class="column span-10 last">
            <div class="column span-2 right small">
              <label>Group</label>
            </div>
            <div class="column span-7 last">
              <select>
                <option>Friends</option>
                <option>Family</option>
              </select>
            </div>
          </div>
        </div>
        <div class="column span-20 last right">
          <button type="submit" class="button positive"> <img alt="" src="images/icons/20-check.png"/>SAVE </button>
          <a class="button negative" href="#"><img src="images/icons/20-x.png" alt=""/>CANCEL</a> </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Export Page</h6>
        <hr />
        <div class="column span-20 menu last"><strong>Full Export</strong>:</div>
        <div class="column span-20 last">
          <div class="column span-20 last">
            <div class="note rounded">To import Contacts or a Database Backup go to the <a href="#">Settings</a> section.</div>
          </div>
          <div class="column span-10 export-row last">
            <div class="column span-2"><img src="images/icons/48-excel.png" width="48" height="48" alt="Excel" /></div>
            <div class="column span-8 export-list last"><strong>All Contacts</strong> <span>(standard)</span>
              <ul>
                <li><a href="#">Export contacts for Outlook, Entourage, or Gmail with CSV</a> </li>
                <li><a href="#">Export as XML</a> </li>
              </ul>
            </div>
          </div>
          <div class="column span-10 export-row last">
            <div class="column span-2"><img src="images/icons/48-database.png" width="48" height="48" alt="Database" /></div>
            <div class="column span-8 export-list last"><strong>Full Database Dump </strong><span>(advanced)</span>
              <ul>
                <li><a href="#">Includes Everything. Settings, Contacts, and MySQL Structure</a></li>
              </ul>
            </div>
          </div>
          <div class="column span-20 last">
            <div class="note rounded">Use this to upload your contacts with otherwebsites, <img src="images/icons/14-x.png" width="14" height="14" alt="X" /> Go to the <a href="#">Settings</a> section to configure your External Applications.</div>
          </div>
          <div class="column span-10 export-row api-list last">
            <div class="column span-2"><img src="images/icons/48-excel.png" width="48" height="48" alt="Excel" /></div>
            <div class="column span-8 last"><strong>API Push</strong>
              <ul>
                <li><a href="#">Basecamp</a> <img src="images/icons/14-x.png" width="14" height="14" alt="X" /></li>
                <li><a href="#">Highrise</a> </li>
              </ul>
            </div>
          </div>
          <div class="column span-20 menu last"><strong>Contacts By Group:</strong></div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> General</strong></div>
            <div class="column span-13 small"><strong>23</strong></div>
            <div class="column span-1 right last"><a href="#"><img src="images/icons/20-excel.png" width="20" height="20" alt="Excel" /></a></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Family</strong></div>
            <div class="column span-13 small"><strong>57</strong></div>
            <div class="column span-1 right last"><a href="#"><img src="images/icons/20-excel.png" width="20" height="20" alt="Excel" /></a></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Work</strong></div>
            <div class="column span-13 small"><strong>81</strong></div>
            <div class="column span-1 right last"><a href="#"><img src="images/icons/20-excel.png" width="20" height="20" alt="Excel" /></a></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Book Club</strong></div>
            <div class="column span-13 small"><strong>1900</strong></div>
            <div class="column span-1 right last"><a href="#"><img src="images/icons/20-excel.png" width="20" height="20" alt="Excel" /></a></div>
          </div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Groups</h6>
        <hr />
        <div class="column span-20 menu last">
          <div class="colum span-1">&nbsp;</div>
          <div class="colum span-5"><strong>Name</strong></div>
          <div class="column span-11"><strong>Count</strong></div>
        </div>
        <div class="column span-20 last">
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> General</strong></div>
            <div class="column span-11 small"><strong>23</strong></div>
            <div class="column span-3 actions right last"><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-pencil.png" width="20" height="20" alt="Home" /><img src="images/icons/20-group-remove.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Family</strong></div>
            <div class="column span-11 small"><strong>57</strong></div>
            <div class="column span-3 actions right last"><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-pencil.png" width="20" height="20" alt="Home" /><img src="images/icons/20-group-remove.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Work</strong></div>
            <div class="column span-11 small"><strong>81</strong></div>
            <div class="column span-3 actions right last"><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-pencil.png" width="20" height="20" alt="Home" /><img src="images/icons/20-group-remove.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
          <div class="column span-20 export-row last">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5"><strong> Book Club</strong></div>
            <div class="column span-11 small"><strong>1900</strong></div>
            <div class="column span-3 actions right last"><img src="images/icons/20-mail.png" width="20" height="20" alt="Mail" /><img src="images/icons/20-pencil.png" width="20" height="20" alt="Home" /><img src="images/icons/20-group-remove.png" width="20" height="20" alt="Addressbook" /></div>
          </div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Google Maps</h6>
        <hr />
        <div class="column span-20 google-maps last">
          <div class="column span-6">
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5 last"><strong><a href="#">General</a></strong></div>
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5 last"><strong><a href="#">Family</a></strong></div>
            <div class="column span-5 prepend-1 last">
              <ul>
                <li>Adam</li>
                <li>Aaron</li>
                <li>Kyle</li>
              </ul>
            </div>
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5 last"><strong><a href="#">Work</a></strong></div>
            <div class="column span-1"><img src="images/icons/20-group.png" width="20" height="20" alt="Group" /></div>
            <div class="column span-5 last"><strong><a href="#">Book Club</a></strong></div>
          </div>
          <div class="column span-14 last" id="map"><img src="images/temp-googlemaps.png" width="550" height="360" alt="Google Maps" />
            <div class="notice rounded"><strong>Select a contact to find directions to, select a second contact to find directions between them.</strong></div>
            <div class="column span-14 last">
              <div class="column span-5">
                <select>
                  <option>- Me -</option>
                  <option>Adam</option>
                  <option>Aaron</option>
                </select>
              </div>
              <div class="column span-2 center"><strong>- to -</strong></div>
              <div class="column span-5">
                <select>
                  <option>- Me -</option>
                  <option>Adam</option>
                  <option>Aaron</option>
                </select>
              </div>
              <div class="column span-2 right last"> <a class="button" href="#">GO</a> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>About</h6>
        <hr />
        <div class="column span-20 google-maps last">
          <div>Once the site is made, this will be created</div>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Settings</h6>
        <hr />
        <div class="column span-20 google-maps last">
          <p>Settings</p>
          <p>Users</p>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Profile</h6>
        <hr />
        <div class="column span-20 google-maps last">
          <p>Username<br />
            Password <br />
            Theme </p>
        </div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Help</h6>
        <hr />
        <div class="column span-20 google-maps last">Once the site is made, this will be created</div>
      </div>
      <div class="column span-20 last content-section">
        <h6>Login</h6>
        <hr />
        <div class="column span-20 last">
          <div class="column span-5">&nbsp;</div>
          <div class="column span-10">
            <div class="error rounded">Invalid Password.</div>
          </div>
          <div class="column span-5 last">&nbsp;</div>
          <div class="column span-5">&nbsp;</div>
          <div class="column span-10 rounded login">
            <div class="column span-10 form-row last">
              <div class="column span-2 right small"><strong>E-Mail</strong></div>
              <div class="column span-7 ">
                <input type="text" class="text" />
              </div>
              <div class="column span-1 actions last"> <img src="images/icons/20-check.png" width="20" height="20" alt="Check" /> </div>
            </div>
            <div class="column span-10 form-row last">
              <div class="column span-2 right small"><strong>Password</strong></div>
              <div class="column span-7">
                <input type="text" class="text" />
              </div>
              <div class="column span-1 actions last"> <img src="images/icons/20-x.png" width="20" height="20" alt="Check" /> </div>
            </div>
            <div class="column span-2 right small"> &nbsp;</div>
            <div class="column span-4">
              <input type="checkbox" name="example"/>
              Remember Me<br/>
            </div>
            <div class="column span-3 last">
              <button type="submit" class="button positive no-margine"> <img alt="" src="images/icons/20-check.png"/>LOG IN</button>
            </div>
          </div>
          <div class="column span-5 last">&nbsp;</div>
          <div class="column span-5">&nbsp;</div>
          <div class="column span-10"><a href="#lostpassword" title="Password Lost and Found">Lost your password?</a></div>
          <div class="column span-5 last">&nbsp;</div>
        </div>
      </div>
      <!--
	END Content ---------------->
    </div>
  </div>
</div>
</body>
</html>
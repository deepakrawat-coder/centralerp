@extends('layouts.main')
@section('content')
      <div class="page-body porject-dash">
          <div class="container-fluid">
            <div class="page-header dash-breadcrumb">
              <div class="row">
                <div class="col-6">                              
                  <h3 class="f-w-600">default</h3>
                </div>
                <div class="col-6">
                  <div class="breadcrumb-sec">
                    <ul class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Dashboard</li>
                      <li class="breadcrumb-item active">Project</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid project-dash">
            <div class="row size-column">
              <div class="col-xl-8 des-xl-100 congrats-sec-main box-col-12">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body p-0">
                        <div class="congrats-sec">
                          <div class="card-header-right">
                            <ul class="setting-option bg-transparent">
                              <li>
                                <div class="setting-badge light-badge"><i class="fa fa-cog"></i></div>
                              </li>
                              <li><i class="view-html fa fa-code"></i></li>
                              <li><i class="icofont icofont-maximize full-card"></i></li>
                              <li><i class="icofont icofont-minus minimize-card"></i></li>
                              <li><i class="icofont icofont-refresh reload-card"></i></li>
                              <li><i class="icofont icofont-error close-card"></i></li>
                            </ul>
                          </div>
                          <div class="congrats-content">
                            <h3>Congratulations mark jecno </h3>
                            <p>Lorem ipsum is simply dummy text of the printing and typesetting printing and typesetting industry.</p><a class="btn btn-light learn-btn" href="blog-single.html">Learn More<i class="fa fa-arrow-right font-primary ms-2"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 box-col-12 box-col-6">
                    <div class="card today-task-sec">
                      <div class="card-header justify-content-between">
                        <h5>Today Task</h5>
                        <div class="center-content">
                          <p>5 Task</p><span>Completed</span>
                        </div>
                        <div class="card-header-right">
                          <ul class="setting-option">
                            <li>
                              <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code font-primary"></i></li>
                            <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                            <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                            <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                            <li><i class="icofont icofont-error close-card font-primary"></i></li>
                          </ul>
                        </div>
                      </div>
                      <div class="card-body p-t-0">
                        <div class="table-responsive task-details">
                          <table class="table table-bordernone">
                            <tbody>
                              <tr>
                                <td><span>Google Project Apply Review</span>
                                  <p>Completed in 3 Hours</p>
                                </td>
                                <td class="progress-showcase">
                                  <div class="progress sm-progress-bar">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <p>75% Percentage</p>
                                </td>
                                <td> <a class="btn light-primary" href="javascript:void(0)">Edit</a></td>
                              </tr>
                              <tr>
                                <td><span>Business Logo Create</span>
                                  <p>Completed in 5 Hours</p>
                                </td>
                                <td class="progress-showcase">
                                  <div class="progress sm-progress-bar">
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <p>Completed</p>
                                </td>
                                <td><a class="btn light-secondary" href="javascript:void(0)">Edit</a></td>
                              </tr>
                              <tr>
                                <td><span>Business Project Research</span>
                                  <p>Completed in 2 Hours</p>
                                </td>
                                <td class="progress-showcase">
                                  <div class="progress sm-progress-bar">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <p>65% Percentage</p>
                                </td>
                                <td><a class="btn light-success" href="javascript:void(0)">Edit</a></td>
                              </tr>
                              <tr>
                                <td><span>Recruitment in IT Department</span>
                                  <p>Completed in 4 Days</p>
                                </td>
                                <td class="progress-showcase">
                                  <div class="progress sm-progress-bar">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <p>90% Percentage</p>
                                </td>
                                <td><a class="btn light-warning" href="javascript:void(0)">Edit</a></td>
                              </tr>
                              <tr>
                                <td><span>Submit Riverfront Project</span>
                                  <p>Completed in 2 Days</p>
                                </td>
                                <td>
                                  <div class="progress-showcase">
                                    <div class="progress sm-progress-bar">
                                      <div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>30% Percentage</p>
                                  </div>
                                </td>
                                <td><a class="btn light-info" href="javascript:void(0)">Edit</a></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="text-center"><a class="f-w-700" href="javascript:void(0)">More...</a></div>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#today-task" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                          <pre><code class="language-html" id="today-task">&lt;div class="card today-task-sec"&gt;
 &lt;div class="card-header justify-content-between"&gt;
   &lt;h5&gt;Today Task&lt;/h5&gt;
 &lt;div class="center-content"&gt;
   &lt;p&gt;5 Task&lt;/p&gt;
   &lt;span&gt;Completed&lt;/span&gt;
 &lt;/div&gt;
 &lt;div class="card-header-right"&gt;
   &lt;ul class="setting-option"&gt;
     &lt;li&gt;&lt;div class="setting-badge"&gt;&lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;&lt;/div&gt;&lt;/li&gt;
     &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
   &lt;/ul&gt;
 &lt;/div&gt;
&lt;/div&gt;
&lt;div class="card-body p-t-0"&gt;
 &lt;div class="table-responsive task-details"&gt;
   &lt;table class="table table-bordernone"&gt;
     &lt;tbody&gt;
       &lt;tr&gt;
         &lt;td&gt;
           &lt;span&gt;Google Project Apply Review&lt;/span&gt;
           &lt;p&gt;Completed in 3 Hours&lt;/p&gt;
         &lt;/td&gt;
         &lt;td class="progress-showcase"&gt;
           &lt;div class="progress sm-progress-bar"&gt;
             &lt;div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
           &lt;/div&gt;
           &lt;p&gt;75% Percentage&lt;/p&gt;
         &lt;/td&gt;
         &lt;td&gt; 
           &lt;a class="btn light-primary" href="javascript:void(0)"&gt;Edit&lt;/a&gt;
         &lt;/td&gt;
       &lt;/tr&gt;
       &lt;tr&gt;
         &lt;td&gt;
           &lt;span&gt;Business Logo Create&lt;/span&gt;
           &lt;p&gt;Completed in 5 Hours&lt;/p&gt;
         &lt;/td&gt;
         &lt;td class="progress-showcase"&gt;
           &lt;div class="progress sm-progress-bar"&gt;
             &lt;div class="progress-bar bg-secondary" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
           &lt;/div&gt;
           &lt;p&gt;Completed&lt;/p&gt;
         &lt;/td&gt;
         &lt;td&gt;
           &lt;a class="btn light-secondary" href="javascript:void(0)"&gt;Edit&lt;/a&gt;
         &lt;/td&gt;
       &lt;/tr&gt;
       &lt;tr&gt;
         &lt;td&gt;
           &lt;span&gt;Business Project Research&lt;/span&gt;
           &lt;p&gt;Completed in 2 Hours&lt;/p&gt;
         &lt;/td&gt;
         &lt;td class="progress-showcase"&gt;
           &lt;div class="progress sm-progress-bar"&gt;
             &lt;div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
           &lt;/div&gt;
           &lt;p&gt;65% Percentage&lt;/p&gt;
         &lt;/td&gt;
         &lt;td&gt;
           &lt;a class="btn light-success" href="javascript:void(0)"&gt;Edit&lt;/a&gt;&lt;/td&gt;
       &lt;/tr&gt;
       &lt;tr&gt;
         &lt;td&gt;
           &lt;span&gt;Recruitment in IT Department&lt;/span&gt;
           &lt;p&gt;Completed in 4 Days&lt;/p&gt;
         &lt;/td&gt;
         &lt;td class="progress-showcase"&gt;
           &lt;div class="progress sm-progress-bar"&gt;
             &lt;div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
           &lt;/div&gt;
           &lt;p&gt;90% Percentage&lt;/p&gt;
         &lt;/td&gt;
         &lt;td&gt;&lt;a class="btn light-warning" href="javascript:void(0)"&gt;Edit&lt;/a&gt;&lt;/td&gt;
       &lt;/tr&gt;
       &lt;tr&gt;
         &lt;td&gt;
           &lt;span&gt;Submit Riverfront Project&lt;/span&gt;
           &lt;p&gt;Completed in 2 Days&lt;/p&gt;
         &lt;/td&gt;
         &lt;td&gt;
           &lt;div class="progress-showcase"&gt;
             &lt;div class="progress sm-progress-bar"&gt;
               &lt;div class="progress-bar bg-info" role="progressbar" style="width: 30%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
             &lt;/div&gt;
             &lt;p&gt;30% Percentage&lt;/p&gt;
           &lt;/div&gt;
         &lt;/td&gt;
         &lt;td&gt;
           &lt;a class="btn light-info" href="javascript:void(0)"&gt;Edit&lt;/a&gt;
         &lt;/td&gt;
       &lt;/tr&gt;
       &lt;/tbody&gt;
     &lt;/table&gt;
   &lt;/div&gt;
   &lt;div class="text-center"&gt;
    &lt;a class="f-w-700" href="javascript:void(0)"&gt;More...&lt;/a&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 box-col-12 box-col-6">
                    <div class="card project-goal-sec">
                      <div class="card-header justify-content-between">
                        <h5>Project Goal</h5>
                        <div class="center-content">
                          <p>Archive</p><span>$658429</span>
                        </div>
                        <div class="card-header-right">
                          <ul class="setting-option">
                            <li>
                              <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code font-primary"></i></li>
                            <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                            <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                            <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                            <li><i class="icofont icofont-error close-card font-primary"></i></li>
                          </ul>
                        </div>
                      </div>
                      <div class="card-body p-0">
                        <div id="radar-chart"></div>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#project-goal" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                          <pre><code class="language-html" id="project-goal">&lt;div class="card project-goal-sec"&gt;
 &lt;div class="card-header justify-content-between"&gt;
   &lt;h5&gt;Project Goal&lt;/h5&gt;
   &lt;div class="center-content"&gt;
     &lt;p&gt;Archive&lt;/p&gt;
     &lt;span&gt;$658429&lt;/span&gt;
   &lt;/div&gt;
   &lt;div class="card-header-right"&gt;
     &lt;ul class="setting-option"&gt;
       &lt;li&gt;
         &lt;div class="setting-badge"&gt;
           &lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;
         &lt;/div&gt;
       &lt;/li&gt;
       &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;/ul&gt;
   &lt;/div&gt;
 &lt;/div&gt;
 &lt;div class="card-body p-0"&gt;
   &lt;div id="radar-chart"&gt;&lt;/div&gt;
 &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 des-xl-100 box-col-12">
                <div class="row">
                  <div class="col-xl-12 col-md-6 des-xl-50 box-col-6">
                    <div class="card project-calendar" data-intro="This is Date picker">
                      <div class="card-header">
                        <h5>calendar</h5>
                        <div class="card-header-right">
                          <ul class="setting-option">
                            <li>
                              <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code font-primary"></i></li>
                            <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                            <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                            <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                            <li><i class="icofont icofont-error close-card font-primary"></i></li>
                          </ul>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="datepicker-here date-picker-university" data-language="en"></div>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#calender-sec" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                          <pre><code class="language-html" id="calender-sec">&lt;div class="card project-calendar" data-intro="This is Date picker"&gt;
 &lt;div class="card-header"&gt;
   &lt;h5&gt;calendar&lt;/h5&gt;
   &lt;div class="card-header-right"&gt;
     &lt;ul class="setting-option"&gt;
       &lt;li&gt;&lt;div class="setting-badge"&gt;&lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;&lt;/div&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
      &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
    &lt;/ul&gt;
  &lt;/div&gt;
&lt;/div&gt;
&lt;div class="card-body"&gt;
  &lt;div class="datepicker-here date-picker-university" data-language="en"&gt;&lt;/div&gt;
 &lt;/div&gt;
&lt;/div&gt;</code></pre>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-xl-12 col-md-6 des-xl-50 box-col-6">
                    <div class="card employee-sec">
                      <div class="card-body">
                        <div class="table-responsive groups-table emp-details-table">
                          <table class="table table-bordernone">
                            <tbody>
                              <tr>
                                <td>
                                  <div class="media">
                                    <div class="round-light icon-secondary"><i class="fa fa-user"></i></div>
                                    <div class="media-body"><span>All Employe Distribute Work</span>
                                      <p>Company,SanFrancisco</p>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p>9:00 to 10:00</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="media">
                                    <div class="round-light icon-primary"><i class="fa fa-check-circle"></i></div>
                                    <div class="media-body"><span>Business Plan is Approved</span>
                                      <p>Elisse Joson,San Francisco</p>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p>10:00 to 1:00</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="media">
                                    <div class="round-light icon-success"><i class="fa fa-graduation-cap"></i></div>
                                    <div class="media-body"><span>Our Education Project Presentation</span>
                                      <p>Company,San Francisco</p>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p>1:10 to 3:15</p>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <div class="media">
                                    <div class="round-light icon-warning"><i class="fa fa-coffee"></i></div>
                                    <div class="media-body"><span>Coffe Break</span>
                                      <p>Our Company All Team Member</p>
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <p>3:15 to 3:30</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-8 des-xl-100 box-col-6">
                <div class="card annual-earning-sec">
                  <div class="card-header justify-content-between">
                    <h5>Annually Earnings</h5>
                    <div class="center-content">
                      <div class="center-content-left">
                        <div class="round bg-primary d-inline-block"></div>
                        <p>Archive</p>
                      </div>
                      <div class="center-content-right">
                        <p>Expected</p>
                      </div>
                    </div>
                    <div class="card-header-right">
                      <ul class="setting-option">
                        <li>
                          <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                        </li>
                        <li><i class="view-html fa fa-code font-primary"></i></li>
                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                        <li><i class="icofont icofont-error close-card font-primary"></i></li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body py-0 p-0">                   
                    <div id="earnings-chart"></div>
                    <div class="code-box-copy">
                      <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#annually-earnings" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                      <pre><code class="language-html" id="annually-earnings">&lt;div class="card annual-earning-sec"&gt;
 &lt;div class="card-header justify-content-between"&gt;
   &lt;h5&gt;Annually Earnings&lt;/h5&gt;
   &lt;div class="center-content"&gt;
     &lt;div class="center-content-left"&gt;
       &lt;div class="round bg-primary d-inline-block"&gt;&lt;/div&gt;
       &lt;p&gt;Archive&lt;/p&gt;
     &lt;/div&gt;
     &lt;div class="center-content-right"&gt;
       &lt;p&gt;Expected&lt;/p&gt;
     &lt;/div&gt;
   &lt;/div&gt;
   &lt;div class="card-header-right"&gt;
     &lt;ul class="setting-option"&gt;
       &lt;li&gt;&lt;div class="setting-badge"&gt;&lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;&lt;/div&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;/ul&gt;
   &lt;/div&gt;
 &lt;/div&gt;
 &lt;div class="card-body py-0 p-0"&gt;
   &lt;div id="earnings-chart"&gt;&lt;/div&gt;
 &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 des-xl-100 box-col-6">
                <div class="card visitor-sec">
                  <div class="card-header justify-content-between">
                    <h5>Visitors Countries</h5>
                    <div class="center-content">
                      <p>Country</p><span>195</span>
                    </div>
                    <div class="card-header-right">
                      <ul class="setting-option">
                        <li>
                          <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                        </li>
                        <li><i class="view-html fa fa-code font-primary"></i></li>
                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                        <li><i class="icofont icofont-error close-card font-primary"></i></li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="jvector-map-height" id="world-map2"></div>
                    <div class="show-value-top d-flex">
                      <div class="counry-data d-inline-block">
                        <div class="round bg-primary d-inline-block"></div><span>South America</span>
                      </div>
                      <div class="counry-data d-inline-block">
                        <div class="round bg-secondary d-inline-block"></div><span>Europe</span>
                      </div>
                      <div class="counry-data d-inline-block">
                        <div class="round bg-warning d-inline-block"></div><span>London</span>
                      </div>
                      <div class="counry-data d-inline-block">
                        <div class="round bg-success d-inline-block"></div><span>Australia</span>
                      </div>
                    </div>
                    <div class="code-box-copy">
                      <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#visitor-countris" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                      <pre><code class="language-html" id="visitor-countris">&lt;div class="card visitor-sec"&gt;
   &lt;div class="card-header justify-content-between"&gt;
     &lt;h5&gt;Visitors Countries&lt;/h5&gt;
     &lt;div class="center-content"&gt;
       &lt;p&gt;Country&lt;/p&gt;&lt;span&gt;195&lt;/span&gt;
     &lt;/div&gt;
     &lt;div class="card-header-right"&gt;
       &lt;ul class="setting-option"&gt;
         &lt;li&gt;
           &lt;div class="setting-badge"&gt;
             &lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;
           &lt;/div&gt;
         &lt;/li&gt;
         &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
         &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
         &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
         &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
         &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;/ul&gt;
     &lt;/div&gt;
   &lt;/div&gt;
   &lt;div class="card-body p-0"&gt;
     &lt;div class="jvector-map-height" id="world-map2"&gt;&lt;/div&gt;
   &lt;div class="show-value-top d-flex"&gt;
         &lt;div class="counry-data d-inline-block"&gt;
           &lt;div class="round bg-primary d-inline-block"&gt;&lt;/div&gt;
           &lt;span&gt;South America&lt;/span&gt;
         &lt;/div&gt;
         &lt;div class="counry-data d-inline-block"&gt;
           &lt;div class="round bg-secondary d-inline-block"&gt;&lt;/div&gt;
           &lt;span&gt;Europe&lt;/span&gt;
         &lt;/div&gt;
         &lt;div class="counry-data d-inline-block"&gt;
           &lt;div class="round bg-warning d-inline-block"&gt;&lt;/div&gt;
           &lt;span&gt;London&lt;/span&gt;
         &lt;/div&gt;
        &lt;div class="counry-data d-inline-block"&gt;
           &lt;div class="round bg-success d-inline-block"&gt;&lt;/div&gt;
           &lt;span&gt;Australia&lt;/span&gt;
         &lt;/div&gt;
     &lt;/div&gt;
   &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-12 box-col-12">
                <div class="card manage-invoice-sec">
                  <div class="card-header pb-0">
                    <h5>Manage Invoice</h5>
                    <div class="card-header-right">
                      <ul class="setting-option">
                        <li>
                          <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                        </li>
                        <li><i class="view-html fa fa-code font-primary"></i></li>
                        <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                        <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                        <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                        <li><i class="icofont icofont-error close-card font-primary"></i></li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="manage-invoice-table">
                      <div class="item">
                        <div class="table-responsive manage-invoice">
                          <table class="table table-bordernone">
                            <thead>
                              <tr>
                                <th>Name </th>
                                <th>Date</th>
                                <th>Project</th>
                                <th>Contact Number</th>
                                <th>Country</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>
                                  <ul class="setting-option">
                                    <li>
                                      <div class="setting-badge"><i class="fa fa-spin fa-cog font-primary"></i></div>
                                    </li>
                                    <li><i class="view-html fa fa-code font-primary"></i></li>
                                    <li><i class="icofont icofont-maximize full-card font-primary"></i></li>
                                    <li><i class="icofont icofont-minus minimize-card font-primary"></i></li>
                                    <li><i class="icofont icofont-refresh reload-card font-primary"></i></li>
                                    <li><i class="icofont icofont-error close-card font-primary"></i></li>
                                  </ul>
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td> <span>01</span>
                                  <div class="t-title"><img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/1_1.png" alt="" data-original-title="" title="">
                                    <div class="d-inline-block align-middle"><a href="user-profile.html"><span class="f-w-500">Smith johson Lorn</span></a></div>
                                  </div>
                                </td>
                                <td> 
                                  <p>16 August,2019 5:10am</p>
                                </td>
                                <td> <span>Business Logo Create</span></td>
                                <td> 
                                  <p>+1(555) 4585 6859</p>
                                </td>
                                <td> 
                                  <p>United Kingdom</p>
                                </td>
                                <td>
                                  <p>$8435.00</p>
                                </td>
                                <td> 
                                  <p>Past Due</p>
                                </td>
                                <td>
                                  <div class="progress-showcase">
                                    <div class="progress sm-progress-bar">
                                      <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td> <span>02</span>
                                  <div class="t-title"><img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/2_2.png" alt="" data-original-title="" title="">
                                    <div class="d-inline-block align-middle"><a href="user-profile.html"><span class="f-w-500">Brown Taylor Jeron</span></a></div>
                                  </div>
                                </td>
                                <td> 
                                  <p>26 Mar,2019 2:10pm</p>
                                </td>
                                <td> <span>Apply Google Review</span></td>
                                <td> 
                                  <p>+880 8759 0013</p>
                                </td>
                                <td> 
                                  <p>Bangladesh</p>
                                </td>
                                <td>
                                  <p>$4542.00</p>
                                </td>
                                <td> 
                                  <p>Paid</p>
                                </td>
                                <td>
                                  <div class="progress-showcase">
                                    <div class="progress sm-progress-bar">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td> <span>03</span>
                                  <div class="t-title"><img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/3_3.png" alt="" data-original-title="" title="">
                                    <div class="d-inline-block align-middle"><a href="user-profile.html"><span class="f-w-500">Admas Lopez Perry</span></a></div>
                                  </div>
                                </td>
                                <td> 
                                  <p>06 Aug,2019 3:10am</p>
                                </td>
                                <td> <span>Recruitment Refrances</span></td>
                                <td> 
                                  <p>+613201 2546</p>
                                </td>
                                <td> 
                                  <p>Australia</p>
                                </td>
                                <td>
                                  <p>$6140.00</p>
                                </td>
                                <td> 
                                  <p>Past Due</p>
                                </td>
                                <td>
                                  <div class="progress-showcase">
                                    <div class="progress sm-progress-bar">
                                      <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td> <span>04</span>
                                  <div class="t-title"><img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/4_4.png" alt="" data-original-title="" title="">
                                    <div class="d-inline-block align-middle"><a href="user-profile.html"><span class="f-w-500">Barker Cartor Ward</span></a></div>
                                  </div>
                                </td>
                                <td> 
                                  <p>22 Sept,2019 2:10pm</p>
                                </td>
                                <td> <span>Project Research</span></td>
                                <td> 
                                  <p>+1-684 8759 0013</p>
                                </td>
                                <td> 
                                  <p>American Samoa</p>
                                </td>
                                <td>
                                  <p>$1526.00</p>
                                </td>
                                <td> 
                                  <p>Paid</p>
                                </td>
                                <td>
                                  <div class="progress-showcase">
                                    <div class="progress sm-progress-bar">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="code-box-copy">
                      <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#manage-invoice" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
                      <pre><code class="language-html" id="manage-invoice">&lt;div class="card manage-invoice-sec"&gt;
 &lt;div class="card-header pb-0"&gt;
   &lt;h5&gt;Manage Invoice&lt;/h5&gt;
   &lt;div class="card-header-right"&gt;
     &lt;ul class="setting-option"&gt;
       &lt;li&gt;
         &lt;div class="setting-badge"&gt;&lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;&lt;/div&gt;
       &lt;/li&gt;
       &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
       &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
     &lt;/ul&gt;
   &lt;/div&gt;
 &lt;/div&gt;
 &lt;div class="card-body"&gt;
   &lt;div class="manage-invoice-table"&gt;
     &lt;div class="item"&gt;
       &lt;div class="table-responsive manage-invoice"&gt;
         &lt;table class="table table-bordernone"&gt;
          &lt;thead&gt;
           &lt;tr&gt;
             &lt;th&gt;Name &lt;/th&gt;
             &lt;th&gt;Date&lt;/th&gt;
             &lt;th&gt;Project&lt;/th&gt;
             &lt;th&gt;Contact Number&lt;/th&gt;
             &lt;th&gt;Country&lt;/th&gt;
             &lt;th&gt;Amount&lt;/th&gt;
             &lt;th&gt;Status&lt;/th&gt;
             &lt;th&gt;
               &lt;ul class="setting-option"&gt;
                 &lt;li&gt;
                   &lt;div class="setting-badge"&gt;&lt;i class="fa fa-spin fa-cog font-primary"&gt;&lt;/i&gt;&lt;/div&gt;
                 &lt;/li&gt;
                 &lt;li&gt;&lt;i class="view-html fa fa-code font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
                 &lt;li&gt;&lt;i class="icofont icofont-maximize full-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
                 &lt;li&gt;&lt;i class="icofont icofont-minus minimize-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
                 &lt;li&gt;&lt;i class="icofont icofont-refresh reload-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
                 &lt;li&gt;&lt;i class="icofont icofont-error close-card font-primary"&gt;&lt;/i&gt;&lt;/li&gt;
               &lt;/ul&gt;
             &lt;/th&gt;
           &lt;/tr&gt;
             &lt;/thead&gt;
               &lt;tbody&gt;
                   &lt;tr&gt;
                     &lt;td&gt; 
                       &lt;span&gt;01&lt;/span&gt;
                       &lt;div class="t-title"&gt;&lt;img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/1_1.png" alt="" data-original-title="" title=""/&gt;
                         &lt;div class="d-inline-block align-middle"&gt;&lt;a href="user-profile.html"&gt;&lt;span class="f-w-500"&gt;Smith johson Lorn&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                     &lt;td&gt;&lt;p&gt;16 August,2019 5:10am&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;span&gt;Business Logo Create&lt;/span&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;+1(555) 4585 6859&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;United Kingdom&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt;&lt;p&gt;$8435.00&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt;&lt;p&gt;Past Due&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt;&lt;div class="progress-showcase"&gt;
                       &lt;div class="progress sm-progress-bar"&gt;
                         &lt;div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
                         &lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                   &lt;/tr&gt;
                   &lt;tr&gt;
                     &lt;td&gt; 
                       &lt;span&gt;02&lt;/span&gt;
                       &lt;div class="t-title"&gt;
                         &lt;img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/2_2.png" alt="" data-original-title="" title=""/&gt;
                         &lt;div class="d-inline-block align-middle"&gt;
                           &lt;a href="user-profile.html"&gt;&lt;span class="f-w-500"&gt;Brown Taylor Jeron&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                     &lt;td&gt; 
                       &lt;p&gt;26 Mar,2019 2:10pm&lt;/p&gt;
                     &lt;/td&gt;
                     &lt;td&gt; &lt;span&gt;Apply Google Review&lt;/span&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;+880 8759 0013&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;Bangladesh&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;$4542.00&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;Paid&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;div class="progress-showcase"&gt;
                       &lt;div class="progress sm-progress-bar"&gt;
                         &lt;div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
                       &lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                   &lt;/tr&gt;
                   &lt;tr&gt;
                     &lt;td&gt; 
                         &lt;span&gt;03&lt;/span&gt;
                         &lt;div class="t-title"&gt;
                           &lt;img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/3_3.png" alt="" data-original-title="" title=""/&gt;
                         &lt;div class="d-inline-block align-middle"&gt;
                           &lt;a href="user-profile.html"&gt;&lt;span class="f-w-500"&gt;Admas Lopez Perry&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;
                         &lt;/div&gt;
                     &lt;/td&gt;
                     &lt;td&gt; 
                       &lt;p&gt;06 Aug,2019 3:10am&lt;/p&gt;
                     &lt;/td&gt;
                     &lt;td&gt; &lt;span&gt;Recruitment Refrances&lt;/span&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;+613201 2546&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;Australia&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;$6140.00&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;Past Due&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt;
                       &lt;div class="progress-showcase"&gt;
                         &lt;div class="progress sm-progress-bar"&gt;
                           &lt;div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
                         &lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                   &lt;/tr&gt;
                   &lt;tr&gt;
                     &lt;td&gt; &lt;span&gt;04&lt;/span&gt;
                       &lt;div class="t-title"&gt;&lt;img class="img-40 rounded-circle align-top" src="../assets/images/dashboard-3/4_4.png" alt="" data-original-title="" title=""/&gt;
                         &lt;div class="d-inline-block align-middle"&gt;&lt;a href="user-profile.html"&gt;&lt;span class="f-w-500"&gt;Barker Cartor Ward&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;22 Sept,2019 2:10pm&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;span&gt;Project Research&lt;/span&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;+1-684 8759 0013&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;American Samoa&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;$1526.00&lt;/p&gt; &lt;/td&gt;
                     &lt;td&gt; &lt;p&gt;Paid&lt;/p&gt;&lt;/td&gt;
                     &lt;td&gt; 
                       &lt;div class="progress-showcase"&gt;&lt;div class="progress sm-progress-bar"&gt;
                           &lt;div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"&gt;&lt;/div&gt;
                         &lt;/div&gt;
                       &lt;/div&gt;
                     &lt;/td&gt;
                   &lt;/tr&gt;
                 &lt;/tbody&gt;
               &lt;/table&gt;
               &lt;/div&gt;
             &lt;/div&gt;
           &lt;/div&gt;
           &lt;/div&gt;
         &lt;/div&gt;</code></pre>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- tap on top starts-->
        <div class="tap-top"><i class="icon-control-eject"></i></div>
@endsection

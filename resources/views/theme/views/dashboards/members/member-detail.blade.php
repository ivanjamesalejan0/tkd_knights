<script>
var requiredCSS = [
  'assets/vendor/sweetalert2/sweetalert2.css',
  'assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
];

loadCSS(requiredCSS);

var requiredJS = [
  'assets/vendor/sweetalert2/sweetalert2.js',
  'assets/vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js',
  'assets/scripts/appviews/appviews-project-detail.js',
  'assets/scripts/members/members-view.setup.js'
];

loadJS(requiredJS);
</script>

<div class="row">
  <div class="col-md-8">
    <div class="panel">
      <div class="project-heading">
        <div class="row">
          <div class="col-md-9">
            <div class="media">
              <div class="media-left">
                <img src="images/{{$member->image ?? 'default_avatar.png'}}" class="project-logo" alt="Project Logo"
                  style="height: 150px; width: auto;">
              </div>
              <div class="media-body">
                <h2 class="project-title">{{$member->lastname}}, {{$member->firstname}} {{$member->middlename}}</h2>
                <span
                  class="label {{ $member->membership_status=='active' ? 'label-success':'label-danger'}} status">{{$member->membership_status}}</span>
                <div class="project-info">
                  <br /><br />
                  <p class="project-description">
                    <strong>Contact</strong>: {{$member->contact}} <br />
                    <strong>E-mail</strong>: {{$member->email}} <br />
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3 text-right">
            <div class="btn-group">
              <button type="button" class="btn btn-primary dropdown-toggle hidden" data-toggle="dropdown"
                aria-expanded="false">ADD NEW <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="#">Milestone</a></li>
                <li><a href="#">Task</a></li>
                <li><a href="#">People</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="project-subheading">
          <div class="layout-table project-metrics">
            <div class="cell">
              <div class="main-info-item">
                <span class="title">MEMBERSHIP</span>
                <span class="value">{{ $member->membership_type }}</span>
              </div>
            </div>
            <div class="cell">
              <div class="main-info-item">
                <span class="title">DATE START</span>
                <span class="value">{{ $member->date_started }}</span>
              </div>
            </div>
            <div class="cell">
              <div class="main-info-item">
                <span class="title">DATE RESTARTED</span>
                <span class="value">{{ $member->date_restarted }}</span>
              </div>
            </div>
            <div class="cell">
              <div class="main-info-item hidden">
                <span class="title">PROGRESS</span>
                <div id="project-progress" class="progress progress-transparent custom-color-orange2">
                  <div class="progress-bar" data-transitiongoal="85"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body">
        <div class="project-info">
          <h3 class="info-heading">BASIC INFORMATION</h3>
          <p class="project-description">
            <strong>Date of Birth</strong>: {{$member->dob}} <br />
            <strong>Gender</strong>: {{$member->gender}} <br />
            <strong>Civil Status</strong>: {{$member->civil_status}} <br />
            <strong>Citizenship</strong>: {{$member->citizenship}} <br />
            <strong>ID Presented</strong>: {{$member->id_type}} <br />
            <strong>ID Number</strong>: {{$member->id_number}} <br />
            <strong>Referrer</strong>: {{$member->referrer}} <br />
          </p>
        </div>
        <div class="project-info">
          <h3 class="info-heading">HOME ADDRESS</h3>
          <p class="project-description">{{$member->home_address['address1']}}, {{$member->home_address['address2']}},
            {{$member->home_address['barangay']}}, {{$member->home_address['city']}},
            {{$member->home_address['province']}}, {{$member->home_address['postal']}}
          </p>
        </div>
        <div class="project-info">
          <h3 class="info-heading">BILLING ADDRESS</h3>
          <p class="project-description">{{$member->billing_address['address1']}},
            {{$member->billing_address['address2']}},
            {{$member->billing_address['barangay']}}, {{$member->billing_address['city']}},
            {{$member->billing_address['province']}}, {{$member->billing_address['postal']}}
          </p>
        </div>

        <div class="project-info">
          <h3 class="info-heading">EMERGENCY INFORMATION</h3>
          <p class="project-description">
            <strong>Person</strong>: {{$member->emergency_person}} <br />
            <strong>Contact</strong>: {{$member->emergency_contact}} <br />
            <strong>Relationship</strong>: {{$member->emergency_relationship}}
          </p>
        </div>

        <div class="project-info">
          <h3 class="info-heading">ATTENDANCE</h3>
          <div class="panel-group project-accordion">
            <!-- project milestone -->
            <div class="panel project-milestone">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a href="#collapse1" data-toggle="collapse" data-parent="#accordion">
                    <span class="milestone-title"><i class="fa fa-check icon-indicator text-success"></i> Active
                      <i class="fa fa-minus-circle toggle-icon"></i>
                  </a>
                </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                  <div class="milestone-section">
                    <div class="table-responsive">
                      <table class="table table-striped table-project-tasks">
                        <thead>
                          <tr>
                            <th>DATE</th>
                            <th>TIME IN</th>
                            <th>TIME OUT</th>
                            <th>ACTIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($member->attendance()->orderBy('created_at','desc')->get() as $attendance)
                          <tr>
                            <td>{{date('Y-m-d',strtotime($attendance->created_at))}}</td>
                            <td>{{date('H:i:s',strtotime($attendance->time_in))}}</td>
                            <td>{{$attendance->time_out ? date('H:i:s',strtotime($attendance->time_out)) : ''}}</td>
                            <td>
                              <span class="actions">
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-trash"></i></a>
                              </span>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-success" onClick="attendanceUpdate({{$member->id}})"><i
                      class="fa fa-check"></i> Toggle Update Attendance</button>
                </div>
              </div>
            </div>
            <!-- end project milestone -->

            <!-- project milestone -->
            <div class="panel project-milestone">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a href="#collapse2" data-toggle="collapse" data-parent="#accordion" class="collapsed">
                    <span class="milestone-title"><i class="fa fa-check icon-indicator text-success"></i> BILLING</span>
                    <span class="label label-danger label-transparent">DUE</span>
                    <i class="fa fa-plus-circle toggle-icon"></i>
                  </a>
                </h4>
              </div>
              <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body hidden">
                  <div class="milestone-section">
                    <h4 class="milestone-heading">DESCRIPTION</h4>
                    <p class="milestone-description">Velit elitr dolore eu pri, ut has vero imperdiet dissentiet, sit
                      magna blandit reformidans in. Alia commune disputationi vis no, natum rebum melius in ius.</p>
                  </div>
                  <div class="milestone-section layout-table project-metrics">
                    <div class="cell">
                      <div class="main-info-item">
                        <span class="title">DATE START</span>
                        <span class="value">Aug 01, 2017</span>
                      </div>
                    </div>
                    <div class="cell">
                      <div class="main-info-item">
                        <span class="title">DATE END</span>
                        <span class="value">Sep 15, 2017</span>
                      </div>
                    </div>
                    <div class="cell">
                      <div class="main-info-item">
                        <span class="title">EST. VALUE</span>
                        <span class="value">$15,600</span>
                      </div>
                    </div>
                    <div class="cell">
                      <div class="main-info-item">
                        <span class="title">DELIVERABLE</span>
                        <span class="value">
                          <i class="fa fa-file-archive-o"></i>
                          <a href="#">BusinessReqs_FINAL.zip</a>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="milestone-section">
                    <div class="table-responsive">
                      <table class="table table-striped table-project-tasks">
                        <thead>
                          <tr>
                            <th>TASK</th>
                            <th>DEADLINE</th>
                            <th>PROGRESS</th>
                            <th>ACTIONS</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td colspan="4" class="divider">COMPLETED TASK</td>
                          </tr>
                          <tr>
                            <td><span class="task-indicator success"></span> Functional Gathering</td>
                            <td>Jul 30, 2017</td>
                            <td>100%</td>
                            <td>
                              <span class="actions">
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-trash"></i></a>
                              </span>
                            </td>
                          </tr>
                          <tr>
                            <td><span class="task-indicator success"></span> Features and Specs</td>
                            <td>Aug 10, 2017</td>
                            <td>100%</td>
                            <td>
                              <span class="actions">
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-trash"></i></a>
                              </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="panel-footer">
                  <a href="#" class="btn btn-default"><i class="fa fa-pencil"></i> EDIT MILESTONE</a>
                  <a href="#" class="btn btn-default"><i class="fa fa-cloud-upload"></i> UPLOAD</a>
                  <a href="#" class="btn btn-success"><i class="fa fa-file"></i> VIEW INVOICE</a>
                </div>
              </div>
            </div>
            <!-- end project milestone -->

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <!-- project team -->
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">Project Team</h4>
        <div class="right">
          <button type="button" class="btn btn-primary">
            <span class="sr-only">Add Contact</span>
            <i class="fa fa-user-plus"></i>
          </button>
        </div>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled list-contacts">
          <li>
            <div class="media">
              <img src="assets/img/people/female3.png" class="picture" alt="">
              <span class="status online"></span>
            </div>
            <div class="info">
              <span class="name">Theresa Santos</span>
              <span class="title">Team Leader</span>
            </div>
            <div class="controls">
              <a href="#"><i class="fa fa-commenting-o"></i></a>
            </div>
          </li>
          <li>
            <div class="media">
              <div class="picture custom-bg-blue3">MB</div>
              <span class="status"></span>
            </div>
            <div class="info">
              <span class="name">Michael Bradley</span>
              <span class="email">Business Analyst</span>
            </div>
            <div class="controls">
              <a href="#"><i class="fa fa-commenting-o"></i></a>
            </div>
          </li>
          <li>
            <div class="media">
              <img src="assets/img/people/male1.png" class="picture" alt="">
              <span class="status online"></span>
            </div>
            <div class="info">
              <span class="name">Bruce Bowman</span>
              <span class="email">UI Designer</span>
            </div>
            <div class="controls">
              <a href="#"><i class="fa fa-commenting-o"></i></a>
            </div>
          </li>
          <li>
            <div class="media">
              <img src="assets/img/people/female4.png" class="picture" alt="">
              <span class="status"></span>
            </div>
            <div class="info">
              <span class="name">Karen Price</span>
              <span class="email">Legal</span>
            </div>
            <div class="controls">
              <a href="#"><i class="fa fa-commenting-o"></i></a>
            </div>
          </li>
          <li>
            <div class="media">
              <img src="assets/img/people/female5.png" class="picture" alt="">
              <span class="status online"></span>
            </div>
            <div class="info">
              <span class="name">Martha Mendoza</span>
              <span class="email">Full-Stack Developer</span>
            </div>
            <div class="controls">
              <a href="#"><i class="fa fa-commenting-o"></i></a>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- end project team -->

    <!-- resource files -->
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">Resource Files</h4>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled list-justify list-file-simple">
          <li><a href="#"><i class="fa fa-file-word-o"></i>Proposal.docx</a> <span>4 MB</span></li>
          <li><a href="#"><i class="fa fa-file-pdf-o"></i>Final_Presentation.ppt</a> <span>20 MB</span></li>
          <li><a href="#"><i class="fa fa-file-zip-o"></i>Phase1_AllFiles.zip</a> <span>315 MB</span></li>
          <li><a href="#"><i class="fa fa-file-excel-o"></i>Meeting_Schedule.xls</a> <span>1 MB</span></li>
        </ul>
      </div>
      <div class="panel-footer text-right">
        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-cloud-upload"></i> UPLOAD FILE</a>
      </div>
    </div>
    <!-- end resource files -->

    <!-- project statistic -->
    <div class="panel">
      <div class="panel-heading">
        <h4 class="panel-title">Project Statistic</h4>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled list-widget-vertical no-border">
          <li>
            <div class="widget-metric_7">
              <i class="fa fa-tasks icon custom-text-blue3"></i>
              <div class="right">
                <span class="value">89 / 142</span>
                <span class="title">Task Delivered</span>
              </div>
            </div>
          </li>
          <li>
            <div class="widget-metric_7">
              <i class="fa fa-money icon custom-text-green"></i>
              <div class="right">
                <span class="value">$5,834 / $21,847</span>
                <span class="title">Payment made</span>
              </div>
            </div>
          </li>
          <li>
            <div class="widget-metric_7">
              <i class="fa fa-calendar-o icon custom-text-orange"></i>
              <div class="right">
                <span class="value">165 / 312</span>
                <span class="title">Days elapsed</span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- end project statistic -->
  </div>
</div>
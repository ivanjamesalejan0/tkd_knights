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
          
    <!-- end project statistic -->
  </div>
</div>
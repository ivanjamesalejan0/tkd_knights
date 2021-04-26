<script>
requiredCSS = [
  'assets/vendor/sweetalert2/sweetalert2.css',
];

loadCSS(requiredCSS);

requiredJS = [
  'assets/vendor/sweetalert2/sweetalert2.js',
  'js/jquery.form-validator.min.js',
  'js/webcam.min.js',
  'assets/scripts/members/member-form.setup.js'
];


loadJS(requiredJS);
</script>

<div class="row">
  <form id="app-form" class="form-horizontal" role="form" method="POST"
    action="{{ isset($member) ? route('members.update',['id'=>$member->id]) : route('members.store') }}"
    autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="{{isset($member) ? 'PUT' : 'POST'}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="image" value="{{$member->image ?? ''}}">

    @if(isset($member))
    <input type="hidden" name="id" value="{{$member->id}}">
    @endif

    <div class="col-md-12">
      <div class="row">
        <div class="col-md-8">
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Members Basic Information</h3>
            </div>
            <div class="panel-body">

              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">First Name</label>
                      <input type="text" name="firstname" class="form-control" value="{{$member->firstname ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Middle Name</label>
                      <input type="text" name="middlename" class="form-control" value="{{$member->middlename ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Last Name</label>
                      <input type="text" name="lastname" class="form-control" value="{{$member->lastname ?? ''}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Date Of Birth</label>
                      <input type="date" name="dob" class="form-control" value="{{$member->dob ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Gender</label>
                      <select name="gender" class="form-control">
                        <option value="male" {{isset($member) && $member->gender=='male'? 'selected': ''}}>Male</option>
                        <option value="female" {{isset($member) && $member->gender=='female'? 'selected': ''}}>Female
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Civil Status</label>
                      <select name="civil_status" class="form-control">
                        <option value="single" {{isset($member) && $member->civil_status=='single'? 'selected': ''}}>
                          Single</option>
                        <option value="married" {{isset($member) && $member->civil_status=='married'? 'selected': ''}}>
                          Married</option>
                        <option value="widowed" {{isset($member) && $member->civil_status=='widowed'? 'selected': ''}}>
                          Widowed</option>
                        <option value="widower" {{isset($member) && $member->civil_status=='widower'? 'selected': ''}}>
                          Widower</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Citizenship</label>
                      <input type="tex" name="citizenship" class="form-control" value="{{$member->citizenship ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Contact Number</label>
                      <input type="text" name="contact" class="form-control" value="{{$member->contact ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">Email</label>
                      <input type="text" name="email" class="form-control" value="{{$member->email ?? ''}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">ID Type</label>
                      <input type="text" name="id_type" class="form-control" value="{{$member->id_type ?? ''}}">
                    </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                    <div class="form-group form-control-container">
                      <label class="control-label">ID Number</label>
                      <input type="text" name="id_number" class="form-control" value="{{$member->id_number ?? ''}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">Picture</h3>
            </div>
            <div class="panel-body">
              <div id="results">
                @if(isset($member) && $member->image)
                <img id="imageprev" src="images/{{$member->image}}" />
                @endif
              </div>
              <br />
              <a class="btn btn-primary" data-toggle="modal" href='#camera-modal'>Take Picture</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Address Information</h3>
        </div>
        <div class="panel-body">
          <fieldset class="form-fieldset">
            <legend class="">Home Address</legend>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Address 1</label>
                    <input type="text" name="home_address1" class="form-control"
                      value="{{$member->home_address['address1'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Address 2</label>
                    <input type="text" name="home_address2" class="form-control"
                      value="{{$member->home_address['address2'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Barangay</label>
                    <input type="text" name="home_barangay" class="form-control"
                      value="{{$member->home_address['barangay'] ?? ''}}">
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">City</label>
                    <input type="text" name="home_city" class="form-control"
                      value="{{$member->home_address['city'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Province</label>
                    <input type="text" name="home_province" class="form-control"
                      value="{{$member->home_address['province'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Postal Code</label>
                    <input type="text" name="home_postal" class="form-control"
                      value="{{$member->home_address['postal'] ?? ''}}">
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-fieldset">
            <legend class="">Billing Address</legend>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-inline fancy-checkbox">
                      <input type="checkbox" name="billing_is_current_address" {{ isset($member) ? '' : 'checked' }}
                        id="same-current-address-checkbox">
                      <span>Same as Current Address</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Address 1</label>
                    <input type="text" name="billing_address1" class="form-control"
                      value="{{$member->billing_address['address1'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Address 2</label>
                    <input type="text" name="billing_address2" class="form-control"
                      value="{{$member->billing_address['address2'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Barangay</label>
                    <input type="text" name="billing_barangay" class="form-control"
                      value="{{$member->billing_address['barangay'] ?? ''}}">
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">City</label>
                    <input type="text" name="billing_city" class="form-control"
                      value="{{$member->billing_address['city'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Province</label>
                    <input type="text" name="billing_province" class="form-control"
                      value="{{$member->billing_address['province'] ?? ''}}">
                  </div>
                </div>
                <div class="col-md-4 col-lg-4">
                  <div class="form-group form-control-container">
                    <label class="control-label">Postal Code</label>
                    <input type="text" name="billing_postal" class="form-control"
                      value="{{$member->billing_address['postal'] ?? ''}}">
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Emergency Information</h3>
        </div>
        <div class="panel-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Emergency Contact Person</label>
                  <input type="text" name="emergency_person" class="form-control"
                    value="{{$member->emergency_person ?? ''}}">
                </div>
              </div>
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Contact Number</label>
                  <input type="text" name="emergency_contact" class="form-control"
                    value="{{$member->emergency_contact ?? ''}}">
                </div>
              </div>
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Relationship</label>
                  <input type="text" name="emergency_relationship" class="form-control"
                    value="{{$member->emergency_relationship ?? ''}}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Membership Information</h3>
        </div>
        <div class="panel-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Membership Type</label>
                  <select name="membership_type" class="form-control">
                    <option value="basic" {{isset($member) && $member->membership_type=='basic'? 'selected': ''}}>Basic
                    </option>
                    <option value="premium" {{isset($member) && $member->membership_type=='premium'? 'selected': ''}}>
                      Premium</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Membership Status</label>
                  <select name="membership_status" class="form-control">
                    <option value="pending" {{isset($member) && $member->membership_status=='pending'? 'selected': ''}}>
                      Pending</option>
                    <option value="active" {{isset($member) && $member->membership_status=='active'? 'selected': ''}}>
                      Active</option>
                    <option value="inactive"
                      {{isset($member) && $member->membership_status=='inactive'? 'selected': ''}}>Inactive
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-lg-4">
                <div class="form-group form-control-container">
                  <label class="control-label">Date Started</label>
                  <input type="date" name="date_started" class="form-control" value="{{$member->date_started ?? ''}}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8 text-right">
      <button type="submit" id="submit-form" class="btn btn-primary">Submit</button>
    </div>

    <div class="modal fade" id="camera-modal">
      <div class="modal-dialog text-center">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Picture</h4>
          </div>
          <div class="modal-body">
            <div id="webcam" class="center-block"></div>
            <input type=button class="btn btn-primary" value="Take Snapshot" onClick="take_snapshot()">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


  </form>
</div>
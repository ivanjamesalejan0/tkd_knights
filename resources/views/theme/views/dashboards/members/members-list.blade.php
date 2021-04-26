<script>
var requiredCSS = [
  'assets/vendor/sweetalert2/sweetalert2.css',
  'assets/vendor/datatables/css-main/jquery.dataTables.min.css',
  'assets/vendor/datatables/css-bootstrap/dataTables.bootstrap.min.css',
  'assets/vendor/datatables-tabletools/css/dataTables.tableTools.css'
];

loadCSS(requiredCSS);

var requiredJS = [
  'assets/vendor/sweetalert2/sweetalert2.js',
  'assets/vendor/datatables/js-main/jquery.dataTables.min.js',
  'assets/vendor/datatables/js-bootstrap/dataTables.bootstrap.min.js',
  'assets/vendor/datatables-colreorder/dataTables.colReorder.js',
  'assets/vendor/datatables-tabletools/js/dataTables.tableTools.js',
  'assets/scripts/members/members-table.setup.js'
];

loadJS(requiredJS);
</script>

<!-- FEATURED DATATABLE -->
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Featured Datatable</h3>
  </div>
  <div class="panel-body">
    <p class="text-right"><a href="members/create" class="btn btn-primary view-links">Create Member</a></p>
    <table id="featured-datatable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Membership Type</th>
          <th>Membership Status</th>
          <th>Date Started</th>
          <th>Date Restarted</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $member)
        <tr>
          <td>{{$member->id}}</td>
          <td><img src="images/{{$member->image ?? 'default_avatar.png'}}" alt="Avatar" class="avatar"></td>
          <td> {{$member->lastname}}, {{$member->firstname}} {{$member->middlename}} </td>
          <td>{{$member->gender}}</td>
          <td>{{$member->contact}}</td>
          <td>{{$member->email}}</td>
          <td>{{$member->membership_type}}</td>
          <td>{{$member->membership_status}}</td>
          <td>{{$member->date_started}}</td>
          <td>{{$member->date_restarted}}</td>
          <td>
            <a href="members/{{$member->id}}" class="btn btn-default view-links">View</a>
            <a href="members/{{$member->id}}/edit" class="btn btn-primary view-links">Edit</a>
            <button type="button" class="btn btn-danger" onClick="deleteMember({{$member->id}})">Archive</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<form id="app-form" class="form-horizontal hidden" role="form" method="POST" autocomplete="off"
  enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_method" value="delete" />
  <input class="btn btn-default" type="submit" value="Delete" />
</form>
<!-- END FEATURED DATATABLE -->
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="@if(Auth::user()->avatar) {{url('/uploads')}}/{{Auth::user()->avatar}} @else {{url('/uploads/avatar')}}/default/avatar.jpg @endif" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="{{url('account')}}/profile"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="active treeview">
        <a href="{{url('account')}}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
        </a>
      </li>
      <li class="{{ Request::segment(2) === 'domains' ? 'treeview active' : null }} {{ Request::segment(2) === 'logs' ? 'active' : null }}">
        <a href="javascript:void(0);">
          <i class="fa fa-external-link" aria-hidden="true"></i>
          <span>Domain</span>   
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('account')}}/domains"><i class="fa fa-circle-o"></i> List</a></li>
          <li><a href="{{url('account')}}/logs"><i class="fa fa-circle-o"></i> Logs</a></li>
        </ul>
      </li>
      <li class="{{ Request::segment(1) === 'settings' ? 'active' : null }} {{ Request::segment(2) === 'profile' ? 'active' : null }} {{ Request::segment(2) === 'configttl' ? 'active' : null }} treeview">
        <a href="{{url('settings')}}">
          <i class="glyphicon glyphicon-cog" aria-hidden="true"></i>
          <span>Settings</span>    
        </a>
        <ul class="treeview-menu">
         @if(get_permission(Auth::user()->is_root,Auth::user()->permission,'settings_edit')) <li><a href="{{url('settings')}}"><i class="fa fa-circle-o text-yellow"></i> <span>Configuration</span></a></li> @else <li><a href="{{url('account/configttl')}}"><i class="fa fa-circle-o text-yellow"></i> <span>Configuration</span></a></li> @endif 
         <li><a href="{{url('account')}}/profile"><i class="fa fa-circle-o text-aqua"></i> <span>Profile</span></a></li>
       </ul>
     </li>
     @if(get_permission(Auth::user()->is_root,Auth::user()->permission,'synchronize_read'))
     <li >
      <a href="{{url('synchronize')}}">
        <i class="glyphicon glyphicon-wrench" aria-hidden="true"></i>
        <span>Synchronize</span>    
      </a>
    </li>
    @endif
    @if(get_permission(Auth::user()->is_root,Auth::user()->permission,'users_'))
    <li class="{{ Request::segment(1) === 'users' ? 'active' : null }} {{ Request::segment(1) === 'user' ? 'active' : null }} {{ Request::segment(2) === 'groups' ? 'active' : null }} treeview">
      <a href="javascript:void(0)"><i class="fa fa-book"></i> <span>Users</span></a>
      <ul class="treeview-menu">
        <li><a href="{{url('users')}}"><i class="fa fa-circle-o text-red"></i> <span>Users</span></a></li>
        <li><a href="{{url('user/add')}}"><i class="fa fa-circle-o text-blue"></i> <span>Add</span></a></li>
        <li><a href="{{url('user/groups')}}"><i class="fa fa-circle-o text-yellow"></i> <span>Groups</span></a></li>
        @endif
      </ul>
    </li>
  </ul>
</section>
<!-- /.sidebar -->
</aside>
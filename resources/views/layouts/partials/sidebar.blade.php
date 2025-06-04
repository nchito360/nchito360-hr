<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="admin/dashboard" class="app-brand-link d-flex align-items-center">
      <img src="logo.png" alt="Logo" style="height: 30px;">
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Admin Panel</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
      <a href="admin/dashboard" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>

    <!-- My Company -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
        <div data-i18n="My Company">My Company</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/company/team" class="menu-link"><div>Manage Team</div></a></li>
        <li class="menu-item"><a href="admin/company/branches" class="menu-link"><div>Manage Branches</div></a></li>
        <li class="menu-item"><a href="admin/company/departments" class="menu-link"><div>Manage Departments</div></a></li>
      </ul>
    </li>

    <!-- My Team -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div data-i18n="My Team">My Team</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/team/members" class="menu-link"><div>Team Members</div></a></li>
        <li class="menu-item"><a href="admin/team/roles" class="menu-link"><div>Roles & Permissions</div></a></li>
        <li class="menu-item"><a href="admin/team/invitations" class="menu-link"><div>Pending Invitations</div></a></li>
      </ul>
    </li>

    <!-- My Branches -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-store"></i>
        <div data-i18n="My Branches">My Branches</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/branches/overview" class="menu-link"><div>Branch Overview</div></a></li>
        <li class="menu-item"><a href="admin/branches/settings" class="menu-link"><div>Branch Settings</div></a></li>
        <li class="menu-item"><a href="admin/branches/new" class="menu-link"><div>Add New Branch</div></a></li>
      </ul>
    </li>

    <!-- My Departments -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-building-house"></i>
        <div data-i18n="My Departments">My Departments</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/departments/overview" class="menu-link"><div>Departmental Overview</div></a></li>
        <li class="menu-item"><a href="admin/departments/settings" class="menu-link"><div>Departmental Settings</div></a></li>
        <li class="menu-item"><a href="admin/departments/new" class="menu-link"><div>Add New Department</div></a></li>
      </ul>
    </li>

    <!-- Profile -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div data-i18n="Profile">Profile</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/profile/overview" class="menu-link"><div>Overview</div></a></li>
        <li class="menu-item"><a href="admin/profile/settings" class="menu-link"><div>Account Settings</div></a></li>
        <li class="menu-item"><a href="admin/profile/notifications" class="menu-link"><div>Notification</div></a></li>
      </ul>
    </li>

    <!-- Account Settings -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Account Settings">Account Settings</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a href="admin/account/profile" class="menu-link"><div>Profile</div></a></li>
        <li class="menu-item"><a href="admin/account/billing" class="menu-link"><div>Billing & Payments</div></a></li>
        <li class="menu-item"><a href="admin/account/security" class="menu-link"><div>Security</div></a></li>
      </ul>
    </li>

    <!-- Help & Support -->
    <li class="menu-item">
      <a href="admin/support" class="menu-link">
        <i class="menu-icon tf-icons bx bx-help-circle"></i>
        <div data-i18n="Help & Support">Help & Support</div>
      </a>
    </li>

    <!-- Logout -->
    <li class="menu-item">
      <a href="admin/logout" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out-circle"></i>
        <div data-i18n="Logout">Logout</div>
      </a>
    </li>
  </ul>
</aside>

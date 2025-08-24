<div class="sidebar">
    <!-- Admin Info at Top -->
    <div class="admin-info">
        <div class="admin-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="admin-details">
            <span class="admin-name">{{ Auth::guard('admin')->user()->name }}</span>
            <span class="admin-role">Administrator</span>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-nav">
        <ul>
            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/branches*') ? 'active' : '' }}">
                <a href="{{ route('admin.branches.index') }}">
                    <i class="fas fa-code-branch"></i>
                    <span>Branches</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/web*') ? 'active' : '' }}">
                <a href="{{ route('admin.web.index') }}">
                    <i class="fas fa-globe"></i>
                    <span>Web</span>
                </a>
            </li>
            <li class="{{ request()->is('admin/review*') ? 'active' : '' }}">
                <a href="{{ route('admin.review.index') }}">
                    <i class="fas fa-globe"></i>
                    <span>Reviews</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout at Bottom -->
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</div>

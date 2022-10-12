<div class="sidebars sticky-top mb-4">
    <div class="sidebar mt-4">
        <div class="sidebar-title text-uppercase">{{ __('User Navigations') }}</div>
        <div class="list-group with-img">
            <div class="list-item">
                <a href="{{ route('frontend.user.profile') }}"
                    class="list-group-item">{{ __('Profile') }}</a>
                <a href="{{ route('frontend.user.favorites') }}"
                    class="list-group-item">{{ __('Favorites') }}</a>
                <a href="{{ route('frontend.user.comments') }}"
                    class="list-group-item">{{ __('Comments') }}</a>
                <a href="{{ route('frontend.login.logout') }}"
                    class="list-group-item text-danger">{{ __('Logout') }}</a>
            </div>
        </div>
    </div>
</div>
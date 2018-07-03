<div class="border-bottom bg-dark text-white text-uppercase small">
  <div class="d-flex justify-content-between">
    <ul class="list-unstyled d-flex m-0 p-0">
      <li class="py-1 px-2 border-right border-secondary"><a class="text-light" href="{{ route('home') }}">Home</a></li>
      <li class="py-1 px-2 border-right border-secondary"><a class="text-light" href="{{ route('page-create') }}">New Page</a></li>
      @isset($page)
        <li class="py-1 px-2 border-right border-secondary"><a class="text-light" href="{{ route('page-edit', $page->slug) }}">Edit Page</a></li>
      @endisset
    </ul>
    <ul class="list-unstyled d-flex m-0 p-0">
      <li class="py-1 px-2">
        <div class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown">Settings</div>
        <ul class="dropdown-menu dropdown-menu-dark settings-menu" role="menu">
          <li class="dropdown-header">Account</li>
          {{-- <li><a href="site.list" >Sites &amp; Organizations</a></li> --}}
          {{-- <li><a href="user.list">Users</a></li> --}}
          {{-- <li><a href="/settings/ip">IP Blocking</a></li> --}}
          {{-- onClick="event.preventDefault(); app.$refs.settings.toggle()" --}}
          <li><a href="{{ route('settings-configuration') }}" >Configuration</a></li>
          {{-- <li><a href="/settings/integrations">Integrations</a></li> --}}
          {{-- <li><a href="/settings/visitor-lookup">Visitor Lookup</a></li> --}}
          {{-- <li class="dropdown-header">Billing</li> --}}
          {{-- <li><a href="/settings/billing">Plans &amp; Billing</a></li> --}}
          {{-- <li><a href="/settings/invoices">Invoices</a></li> --}}
          {{-- <li class="dropdown-header ellipsis">{{ Auth::user()->email }}</li> --}}
          {{-- <li><a href="/profile/details">My Details</a></li> --}}
          {{-- <li><a href="/profile/notifications">Notifications</a></li> --}}
          {{-- <li><a href="profile.referrals">Refer Friends</a></li> --}}
          {{-- <li><a class="danger">Logout</a></li> --}}
        </ul>
      </li>
      <li class="py-1 px-2">
        <a class="text-light" href="{{ route('logout') }}"
           onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </div>
</div>

@extends('layouts.app')
@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 d-none d-md-block bg-light sidebar">
          <ul class="nav flex-column">
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>Account</span></h6>
            <li class="nav-item"><a class="nav-link" href="site.list" >Sites &amp; Organizations</a></li>
            <li class="nav-item"><a class="nav-link" href="user.list">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="/settings/ip">IP Blocking</a></li>
            {{-- onClick="event.preventDefault(); app.$refs.settings.toggle()" --}}
            <li class="nav-item"><a class="nav-link" href="{{ route('settings-configuration') }}" >Configuration</a></li>
            <li class="nav-item"><a class="nav-link" href="/settings/integrations">Integrations</a></li>
            <li class="nav-item"><a class="nav-link" href="/settings/visitor-lookup">Visitor Lookup</a></li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>Billing</span></h6>
            <li class="nav-item"><a class="nav-link" href="/settings/billing">Plans &amp; Billing</a></li>
            <li class="nav-item"><a class="nav-link" href="/settings/invoices">Invoices</a></li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted"><span>{{ Auth::user()->email }}</span></h6>
            <li class="nav-item"><a class="nav-link" href="/profile/details">My Details</a></li>
            <li class="nav-item"><a class="nav-link" href="/profile/notifications">Notifications</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.referrals">Refer Friends</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
          </ul>
        </div>
        <div class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            @yield('main')
        </div>
    </div>
</div>
@endsection

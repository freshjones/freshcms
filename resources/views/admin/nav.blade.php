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
      <li class="py-1 px-2"><a class="text-light" href="mailto:hello@freshjones.com">My Account</a></li>
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

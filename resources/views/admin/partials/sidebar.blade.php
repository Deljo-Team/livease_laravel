<nav class="sidebar sidebar-start show" tabindex="-1" id="sidebar" data-bs-keyboard="false" data-bs-backdrop="true" data-bs-scroll="true">
    <div class="sidebar-header border-bottom">
      <a href="/" class="d-flex align-items-center text-decoration-none sidebar-title d-sm-block">
        <h3>
          <i class="bi bi-chat-right-text-fill"></i>
          {{ config('app.name', 'Livease') }}
        </h3>
      </a>
    </div>
    <div class="sidebar-body px-0">
      <ul class="list-unstyled ps-0">
        {{-- <li class="mb-1 list-level-1">
          <button
            class="btn btn-toggle align-items-center rounded"
            data-bs-toggle="collapse"
            data-bs-target="#home-collapse"
            aria-expanded="true"
          >
            General
          </button>
          <div class="collapse show" id="home-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small level-2">
              <li><a href="/countries" class="rounded">Countries</a></li>
              <li><a href="#" class="rounded">Categories</a></li>
              <li><a href="#" class="rounded">Reports</a></li>
            </ul>
          </div>
        </li> --}}
        <li class="mb-1 list-level-1">
          <button
            class="btn btn-toggle align-items-center rounded "
            data-bs-toggle="collapse"
            data-bs-target="#dashboard-collapse"
            aria-expanded="false"
          >
            Vendor
          </button>
          <div class="collapse show" id="dashboard-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small level-2">
              <li><a href="{{route('vendor.list')}}" class="rounded">List</a></li>
              <li><a href="{{route('vendor.approve')}}" class="rounded">Approval</a></li>
            </ul>
          </div>
        </li>
        {{-- <li class="mb-1 list-level-1">
          <button
            class="btn btn-toggle align-items-center rounded collapsed"
            data-bs-toggle="collapse"
            data-bs-target="#orders-collapse"
            aria-expanded="false"
          >
            Orders
          </button>
          <div class="collapse" id="orders-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="rounded">New</a></li>
              <li><a href="#" class="rounded">Processed</a></li>
              <li><a href="#" class="rounded">Shipped</a></li>
              <li><a href="#" class="rounded">Returned</a></li>
            </ul>
          </div>
        </li> --}}
        <li class="border-top my-3"></li>
        <li class="mb-1 list-level-1">
          <button
            class="btn btn-toggle align-items-center rounded collapsed"
            data-bs-toggle="collapse"
            data-bs-target="#account-collapse"
            aria-expanded="false"
          >
            Account
          </button>
          <div class="collapse" id="account-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              {{-- <li><a href="#" class="rounded">Profile</a></li> --}}
              {{-- <li><a href="#" class="rounded">Settings</a></li> --}}
              <li><a href="{{route('logout')}}" class="rounded" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Log out</a></li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </nav>
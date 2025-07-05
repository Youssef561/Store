<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        <span class="navbar-badge badge text-bg-warning">{{ $newCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">{{ $newCount }} Notifications</span>
        <div class="dropdown-divider"></div>
        @foreach($notifications as $notification)

        <a href="{{ $notification->data['url'] }}?notification_id={{$notification->id}}" class="dropdown-item @if($notification->unread()) text-bold @endif">
            <i class=" {{$notification->data['icon'] }} mr-2"></i> {{$notification->data['body'] }}
            <span class="float-end text-secondary fs-7">{{$notification->created_at->diffForHumans() }}</span>
        </a>
        <div class="dropdown-divider"></div>
        @endforeach
        <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
    </div>
</li>

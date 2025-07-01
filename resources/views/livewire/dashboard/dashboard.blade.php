<div class="my-6">
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <a href="/dashboard/enquiries">
            <x-dashboard.summary path="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                :data="$enquiries" text="Total Enquiries" />
        </a>

        <a href="/dashboard/properties">
            <x-dashboard.summary
                path="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                :data="$properties" text="Total Properties" />
        </a>

        @if (Auth::user()->role === 'remwdstate20')
        <a href="/dashboard/users">
            <x-dashboard.summary path="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                :data="$users" text="Total Users" />
        </a>

        <a href="/dashboard/blog-posts">
            <x-dashboard.summary
                path="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                :data="$blogs" text="Total Posts" />
        </a>

        @endif
    </div>
</div>
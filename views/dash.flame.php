@extends:.src/:assets/app;

@yield:main;

<div class="bg-gray-900 p-5 rounded">
    <h1 class="text-3xl text-sweetred">Dashboard</h1>
                                    {{-- Simple server side comment,
                                        Get the username by the user instance
                                        returned by the user() function
                                    }}
    <p>Welcome! You're logged in as <b>{{ ucfirst(user()->username) }}</b>.</p>
</div>

@endyield:main;
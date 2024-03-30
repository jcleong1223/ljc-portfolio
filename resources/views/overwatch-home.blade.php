@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
					Ecosystems:
                    <ul>
                        <li><a href="{{ route("telescope") }}">Telescope</a></li>
                        <li><a href="{{ route("hubblescope") }}">Hubblescope</a></li>
					</ul>
					Actions:
					<ul>
                        <li>
                            <a
								href="{{ url('/logout') }}"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('overwatch.logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endAuth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends:.src/:assets/app;

@yield:main;

<div class="bg-gray-900 p-5 rounded-lg">
     <h1 class="text-3xl">User</h1>
     <hr class="border-2 border-gray-800 rounded-lg my-3">

     @if($is_mine): <form method="POST" action="{{ route('user',$username) }}"> @endif
          <div class="text-start">
          @foreach($fields as $key => $field):
               @if($key != 'username' && $key != 'id'):
                    <!-- Form Inputs -->
                    <div>
                         <label>{{ucfirst($key)}}</label>
                         <input type="text" name="{{ $key }}" value="{{ $field }}" {{ $is_mine && $key == 'email' ? '' : 'disabled' }} class="transition duration-150 w-full px-4 py-3 rounded border-none bg-gray-800 border focus:bg-gray-600 hover:bg-gray-700 focus:outline-none my-1" /><br/>
                         <!-- If any session has been saved by the previous request -->
                         @if(isset(session()['errors'][$key])): <label class="text-danger">{{ session()['errors'][$key] }}</label> @endif
                    </div>
               @endif
          @endforeach
               {{-- Input for request method, bc html only supports get and post }}
               <input type="hidden" name="_method" value="PUT">
          </div>
          <div class="mt-2">
               <a class="transition duration-150 text-white bg-sweetred font-medium rounded-md text-sm px-5 py-2.5 mr-2 mb-2 hover:opacity-90 focus:opacity-80" href="@route('index')">Back to home</a>
               @if($is_mine): <button class="transition duration-150 text-white bg-sweetred font-medium rounded-md text-sm px-5 py-2.5 mr-2 mb-2 hover:opacity-90 focus:opacity-80">Update</button> @endif
          </div>
     @if($is_mine): </form> @endif

</div>

@endyield:main;
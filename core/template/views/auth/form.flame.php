<form action="{{ $route }}" method="POST">
    <div class="inputBox">
        @foreach($fields as $field_name => $field):
            <input type="{{$field['type'] ?: 'text'}}" name="{{$field_name}}" placeholder="{{ ucfirst($field_name) }}" value="{{ request()->has($field_name) }}" class="transition duration-150 w-full px-4 py-3 rounded border-none bg-gray-800 border focus:bg-gray-600 hover:bg-gray-700 focus:outline-none my-1" /><br/>
            @if($error = $errors[$field_name]):
                <p class="text-sweetred mb-1"><b>&times;</b> {{$error}}</p>
            @endif
        @endforeach
    </div>
    <button class="mt-2 transition duration-150 text-white bg-sweetred font-medium rounded-md text-sm px-5 py-2.5 mr-2 mb-2 hover:opacity-90 focus:opacity-80 w-full" type="submit">{{$form_submit ?: 'Submit'}}</button>
    <div class="text-center">
        @if($message):
        <p class="text-white">
            {{ $message }} {{ \Core\App\Session::get('back.message') }}
        </p>
        @endif
    </div>
    @CSRF
</form>
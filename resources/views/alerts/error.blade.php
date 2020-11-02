@if(Illuminate\Support\Facades\Session::has('error'))
    <div class="row mr-2 ml-2" >
        <button type="text" class="error btn btn-lg btn-block btn-outline-danger mb-2"
                id="type-error">{{Illuminate\Support\Facades\Session::get('error')}}
        </button>
    </div>
@endif

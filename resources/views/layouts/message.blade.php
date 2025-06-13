@if ($errors->any())
    <div class="alert alert-danger" style="width: 350px !important">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{$item}}</li>
            @endforeach
        </ul>
    </div>

@endif
@if (Session::get('success'))
    <div style="width: 350px !important" class="alert alert-success alert-dismissible fade show">
        <ul>
            <li>{{Session::get('success')}}</li>
        </ul>
    </div>

@endif

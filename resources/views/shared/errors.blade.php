@if ($errors->any())
    <div class="alert alert-danger m-4 pb-1">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
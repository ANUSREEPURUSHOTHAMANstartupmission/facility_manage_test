<div class="card">
    <div class="card-body">

        <form action="{{$action}}" method="post" {{$multipart?'enctyp="multipart/form-data"':''}}>
            @csrf

            {{$slot}}

            <div class="d-flex justify-content-between">
                <a href="{{$link?$link:route($back)}}" class="btn btn-ghost-info">Back</a>
                <button class="btn btn-primary ms-auto" type="submit">Save</button>
            </div>
        </form>

    </div>
</div>
@if (session('alert-success'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible mb-0" role="alert">
            <div>{{ session('alert-success') }}</div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
@if (session('alert-danger'))
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible mb-0" role="alert">
            <div>{{ session('alert-danger') }}</div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
@if (session('alert-warning'))
    <div class="col-12">
        <div class="alert alert-warning alert-dismissible mb-0" role="alert">
            <div>{{ session('alert-warning') }}</div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
@if (session('alert-yellow'))
    <div class="col-12">
        <div class="alert alert-yellow alert-dismissible mb-0" role="alert">
            <div>{{ session('alert-yellow') }}</div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
@if (session('alert-info'))
    <div class="col-12">
        <div class="alert alert-info alert-dismissible mb-0" role="alert">
            <div>{{ session('alert-info') }}</div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif
@if ($errors->any())
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible mb-0" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    </div>
@endif

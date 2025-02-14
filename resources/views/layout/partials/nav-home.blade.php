<nav class="navbar sticky-top shadow-sm navbar-expand-lg navbar-light py-2">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">
            <img class="img-fluid" src="{{asset('/images/logo.png')}}" alt="" width="96px">
        </a>
        <button class="navbar-toggler border bg-body" type="button" data-bs-toggle="collapse" data-bs-target="#header01" aria-controls="header01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="header01">
            <ul class="navbar-nav ms-auto mt-3 mt-lg-0 mb-3 mb-lg-0 me-4">
                <li class="nav-item me-4"><a class="nav-link" href="{{url('/')}}">Products</a></li>
                <li class="nav-item me-4"><a class="nav-link" href="{{url('/about')}}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/testmonials')}}">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/contact')}}">Contact</a></li>
            </ul>
            <div><a class="btn mt-3 bg-gradient-primary" href="{{url('/userLogin')}}">Start Sale</a></div>
        </div>
    </div>
</nav>

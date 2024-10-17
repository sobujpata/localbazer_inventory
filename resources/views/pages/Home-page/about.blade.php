<section class="pb-5">
    <div class="container pt-2">
        <div class="row align-items-center mb-5">
            <div class="col-12 col-lg-7 mb-5 mb-lg-0">
                <h2 class=" fw-bold mb-3">Welcome to Localbazer.com, </h2>
                <p class="lead text-muted mb-4" style="text-align: justify;"> your go-to solution for efficient and streamlined inventory management. We understand how critical it is for businesses to keep track of their stock in real time, and we’re here to simplify that process with our powerful, user-friendly platform.</p>
                <div class="d-flex flex-wrap">
                    {{-- <a class="btn bg-gradient-primary me-2 mb-2 mb-sm-0" href="{{url('/userLogin')}}">Start Sale</a> --}}
                    <a class="btn bg-gradient-primary mb-2 mb-sm-0" href="{{url('/userLogin')}}">Login</a>
                </div>
            </div>
            <div class="col-12 col-lg-4 offset-lg-1">
                {{-- <img class="img-fluid" src="{{asset('/images/hero.svg')}}" alt=""> --}}
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{asset('/images/salim.jpg')}}" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset('/images/ibrahim.jpg')}}" class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="{{asset('/images/rubel.jpg')}}" class="d-block w-100" alt="...">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
        </div>
    </div>
</section>

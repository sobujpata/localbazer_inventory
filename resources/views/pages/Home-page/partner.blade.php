@extends('layout.app')
@section('content')

<section class="pb-5" id="testmonials">
    <div class="container">
        <div class="row ">
            <div class="col-12 col-lg-8 mx-auto text-center pt-4">
                <span class="text-muted"><h2>Our partner</h2></span>
                <p class="lead text-muted" style="text-align: justify;">At <a href="https://www.localbazer.com/iventory">Localbzara.com/Inventrory</a>, we are proud to collaborate with a network of trusted partners who share our vision for excellence in inventory management. Our partnerships allow us to deliver top-tier services, cutting-edge technology, and seamless integrations to meet the diverse needs of businesses around the globe.</p>
            </div>
        </div>
        <br/>
        <div class="row justify-content-center ">
            <div class="col-12 col-md-6 col-lg-3 p-3">
                <div class="card px-0 text-center">
                    <img class=" card-img-top mb-3 w-100 h-100" src="{{asset('/images/salim.jpg')}}" alt="">
                    <h5>Md Salim Reza</h5>
                    <p class="text-muted mb-4">CO &amp; Founder</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 p-3">
                <div class="card px-0 text-center">
                    <img class=" card-img-top mb-3 w-100 h-100" src="{{asset('/images/ibrahim.jpg')}}" alt="">
                    <h5>Md Ibrahim Hossain</h5>
                    <p class="text-muted mb-4">CO &amp; Founder</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 p-3">
                <div class="card px-0 text-center">
                    <img class=" card-img-top mb-3 w-100 h-100" src="{{asset('/images/rubel.jpg')}}" alt="">
                    <h5>Md Rubel Rana</h5>
                    <p class="text-muted mb-4">CO &amp; Founder</p>
                </div>
            </div>
            {{-- <div class="col-12 col-md-6 col-lg-3 p-3">
                <div class="card px-0 text-center">
                    <img class=" card-img-top mb-3 w-100" src="{{asset('/images/man.jpg')}}" alt="">
                    <h5>Danny Bailey</h5>
                    <p class="text-muted mb-4">CEO &amp; Founder</p>
                </div>
            </div> --}}
        </div>
    </div>
</section>

@endsection

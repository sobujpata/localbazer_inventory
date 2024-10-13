@extends('layout.app')

@section('content')

    <nav class="navbar sticky-top shadow-sm navbar-expand-lg navbar-light py-2">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="img-fluid" src="{{asset('/images/logo.png')}}" alt="" width="96px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header01" aria-controls="header01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="header01">
                <ul class="navbar-nav ms-auto mt-3 mt-lg-0 mb-3 mb-lg-0 me-4">
                    <li class="nav-item me-4"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item me-4"><a class="nav-link" href="#service">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testmonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <div><a class="btn mt-3 bg-gradient-primary" href="{{url('/userLogin')}}">Start Sale</a></div>
            </div>
        </div>
    </nav>


        <section class="pb-5">
            <div class="container pt-2">
                <div class="row align-items-center mb-5">
                    <div class="col-12 col-md-10 col-lg-5 mb-5 mb-lg-0">
                        <h2 class=" fw-bold mb-3">Welcome to Localbazer.com, </h2>
                        <p class="lead text-muted mb-4"> your go-to solution for efficient and streamlined inventory management. We understand how critical it is for businesses to keep track of their stock in real time, and we’re here to simplify that process with our powerful, user-friendly platform.</p>
                        <div class="d-flex flex-wrap"><a class="btn bg-gradient-primary me-2 mb-2 mb-sm-0" href="{{url('/userLogin')}}">Start Sale</a>
                            <a class="btn bg-gradient-primary mb-2 mb-sm-0" href="{{url('/userLogin')}}">Login</a></div>
                    </div>
                    <div class="col-12 col-lg-6 offset-lg-1">
                        <img class="img-fluid" src="{{asset('/images/hero.svg')}}" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="pb-5" id="service">
            <div class="container">
                <div class="row ">
                    <div class="col-12 col-lg-8 mx-auto">
                        <span class="text-muted text-center"><h3>Our Service</h3></span>
                        <p class="lead text-muted">At <a href="https://www.localbazer.com/iventory">Localbzara.com/Inventrory</a>, we are proud to collaborate with a network of trusted partners who share our vision for excellence in inventory management. Our partnerships allow us to deliver top-tier services, cutting-edge technology, and seamless integrations to meet the diverse needs of businesses around the globe.</p>
                         <h5>Why Choose Our Wholesale Service?</h5>
                         <ol>
                            <li>
                                <h6>
                                    Bulk Order Management
                                </h6>
                                <p>
                                    Manage large volumes of products with ease. Our system allows for efficient processing of bulk orders, from order placement to fulfillment. You can track orders in real time and stay on top of stock levels, ensuring smooth operations.
                                </p>
                            </li>
                            <li>
                                <h6>
                                    Special Pricing for Wholesale
                                </h6>
                                <p>
                                    Enjoy flexible pricing options tailored specifically for wholesale buyers. Set up tiered pricing models based on the quantity purchased, offering discounts and incentives to your bulk customers.                                </p>
                            </li>
                            <li>
                                <h6>
                                    Customizable Catalogs
                                </h6>
                                <p>
                                    Create and manage customized product catalogs for different clients. Offer a tailored selection of products with client-specific pricing, ensuring that your wholesale customers receive personalized service.                            </li>
                                </p>
                            </li>
                            <li>
                                <h6>
                                    Inventory Tracking in Real Time
                                </h6>
                                <p>
                                    Stay updated on stock availability across multiple warehouses and locations. Our platform provides real-time insights into your inventory, allowing you to avoid overstocking or stockouts and ensuring you can meet customer demand.
                                </p>
                            </li>
                            <li>
                                <h6>
                                    Seamless Integration with Suppliers
                                </h6>
                                <p>
                                    Integrate your system with supplier networks to streamline restocking and order fulfillment. Automated alerts can notify you when stock levels are low, making it easier to maintain a balanced inventory without manual intervention.
                                </p>
                            </li>
                            <li>
                                <h6>
                                    Multi-Location Support
                                </h6>
                                <p>
                                    Whether you're managing inventory in one location or across multiple warehouses, our platform supports easy tracking and movement of goods between locations, ensuring efficient wholesale operations.
                                </p>
                            </li>
                            <li>
                                <h6>
                                    Comprehensive Reporting
                                </h6>
                                <p>
                                    Gain insights into wholesale trends, top-selling products, and customer behavior with our detailed reporting tools. Analyze sales data, purchase history, and stock levels to make informed decisions that optimize your wholesale business.
                                </p>
                            </li>
                                    
                        </ol>
                        <hr>
                        <h4>Get Started with Wholesale Today</h4>
                        <p>If you're looking to streamline your wholesale operations, [Your Inventory Website Name] offers the tools and features you need to succeed. Sign up today or contact our team for a personalized demo, and let us help you take your wholesale business to the next level.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-5" id="testmonials">
            <div class="container">
                <div class="row ">
                    <div class="col-12 col-lg-8 mx-auto text-center">
                        <span class="text-muted"><h3>Our partner</h3></span>
                        <p class="lead text-muted">At <a href="https://www.localbazer.com/iventory">Localbzara.com/Inventrory</a>, we are proud to collaborate with a network of trusted partners who share our vision for excellence in inventory management. Our partnerships allow us to deliver top-tier services, cutting-edge technology, and seamless integrations to meet the diverse needs of businesses around the globe.</p>
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
        

        <br/>

        <section class="py-5" id="contact">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-lg-5 mb-5 mb-lg-0">
                        <h2 class="fw-bold mb-5">Contact Us for Wholesale Inquiries</h2>
                        <h4 class="fw-bold">Address</h4>
                        <p class="text-muted mb-5">Bannyakandi Baza, Ullapara, Sirajganj</p>
                        <h4 class="fw-bold">Contact Us</h4>
                        <p class="text-muted mb-1"><i class="fa fa-envelope"></i> localbazer24@gmail.com</p>
                        <p class="text-muted mb-0"><i class="fa fa-phone"></i> +8801745760265</p>
                        <p class="text-muted mb-0"><i class="fa fa-phone"></i> +8801739871705</p>
                        <p class="text-muted mb-0"><i class="fa fa-phone"></i> +8801771378258</p>
                    </div>
                    <div class="col-12 col-lg-6 offset-lg-1">
                        <form action="" id="save-form">
                            @csrf
                            <input class="form-control mb-3" type="text" placeholder="Name" id="name">
                            <input class="form-control mb-3" type="email" placeholder="E-mail" id="email">
                            <input class="form-control mb-3" type="mobile" placeholder="Mobile No" id="mobile">
                            <input class="form-control mb-3" type="address" placeholder="Your Address" id="address">
                            <textarea class="form-control mb-3" name="message" cols="30" rows="10" placeholder="Your Message..." id="message"></textarea>
                            <button class="btn bg-gradient-primary w-100" onclick="submitData()">Action</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-5 bg-light">
            <div class="container text-center pb-5 border-bottom">
                <a class="d-inline-block mx-auto mb-4" href="#">
                    <img class="img-fluid"src="{{asset('/images/logo.png')}}" alt="" width="96px">
                </a>
                <ul class="d-flex flex-wrap justify-content-center align-items-center list-unstyled mb-4">
                    <li><a class="link-secondary me-4" href="#about">About</a></li>
                    <li><a class="link-secondary me-4" href="#services">Services</a></li>
                    <li><a class="link-secondary" href="#testimonials">Testimonials</a></li>
                    <li><a class="link-secondary me-4" href="#contact">Contact</a></li>
                </ul>
                <div>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/facebook.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/twitter.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/github.svg')}}">
                    </a>
                    <a class="d-inline-block me-4" href="#">
                        <img src="{{asset('/images/instagram.svg')}}">
                    </a>
                    <a class="d-inline-block" href="#">
                        <img src="{{asset('/images/linkedin.svg')}}">
                    </a>
                </div>
            </div>
            <div class="mb-5"></div>
            <div class="container">
                <p class="text-center">All rights reserved © localbazer.com 2024</p>
                <span>Developed By <a href="https://salimreza.xyz/">Md Salim Reza</a></span>
            </div>
        </footer>
@endsection
<script>
    async function submitData(){
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let mobile = document.getElementById('mobile').value;
        let address = document.getElementById('address').value;
        let message = document.getElementById('message').value;

        if(name.length === 0){
            errorToast('Name is Required.')
        }else if(email.length === 0){
            errorToast('Email is Required.')    
        }else if(mobile.length === 0){
            errorToast('Mobile is required')
        }else if(address.length === 0){
            errorToast('Address is required')
        }else if(message.legnth === 0){
            errorToast('Message is required')
        }else{
            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('mobile', mobile);
            formData.append('address', address);
            formData.append('message', message);

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/customer-message", formData, config);
            hideLoader();

            if(res.status === 200){
                successToast('Message Sent Successfully');
                // document.getElementById('save-form').reset();
            }else{
                errorToast('Failed to send message')
            }
        }
    }
</script>




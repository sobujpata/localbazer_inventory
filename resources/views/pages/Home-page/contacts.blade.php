@extends('layout.app')
@section('content')

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

@endsection

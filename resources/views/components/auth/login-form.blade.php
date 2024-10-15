<style>
    .bg-img {
        background-image: url("{{ asset('images/login-img.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;   /* Full viewport height */
        margin: 0; 
    }
    .card{
        background-color: #bd9f9f87 !important;
    }
</style>
<div class="container-flued bg-img">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>

                </div>
            </div>
        </div>
    </div>
</div>


<script>

  async function SubmitLogin() {
            let email=document.getElementById('email').value;
            let password=document.getElementById('password').value;

            if(email.length===0){
                errorToast("Email is required");
            }
            else if(password.length===0){
                errorToast("Password is required");
            }
            else{
                showLoader();
                let res=await axios.post("/user-login",{email:email, password:password});
                hideLoader()
                if(res.status===200 && res.data['status']==='success'){
                    window.location.href="/dashboard";
                }
                else{
                    errorToast(res.data['message']);
                }
            }
    }

</script>

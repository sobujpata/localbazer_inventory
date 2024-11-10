<div class="container-fluid mobile-view">
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @foreach ($partners as $partner)
        <div class="col-md-4 col-12">
            <div class="card px-1">
                <div class="card-body">
                    <img src="{{$partner->image}}" alt="{{ $partner->user->firstName }}" class="w-100 rounded-2">
                    <h3>{{ $partner->user->firstName }} {{ $partner->user->lastName }}</h3>
                    <p>
                        Donnet Amount : {{$partner->amount}} <br>
                        Withdraw Amount : {{$partner->withdraw_amount}}
                    </p>
                    <button type="button" class="btn m-0 bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#deposit{{$partner->id}}">
                        Deposit
                    </button>

                        <!-- Modal -->
                    <div class="modal fade" id="deposit{{$partner->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Deposit Amount</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('partner-deposit') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="number" name="id" class="d-none" value="{{$partner->id}}">
                                <input type="number" name="old_amount" class="d-none" value="{{$partner->amount}}" id="old_amount" required>
                                <div class="form-group">
                                    <label for="amount">Diposit Amount</label>
                                    <input type="text" name="amount" class="form-control" value="" id="amount" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </form>
                            </div>

                            </div>
                        </div>
                    </div>

                    {{-- <button type="button" class="btn m-0 bg-gradient-success" data-bs-toggle="modal" data-bs-target="#withdraw{{$partner->id}}">
                        Withdraw
                    </button> --}}
                    <div class="modal fade" id="withdraw{{$partner->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw Amount</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url('partner-withdraw') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="number" name="id" class="d-none" value="{{$partner->id}}">

                                <input type="number" name="old_amount" class="d-none" value="{{$partner->withdraw_amount}}" id="old_amount" required>
                                <div class="form-group">
                                    <label for="amount">Withdraw Amount</label>
                                    <input type="text" name="amount" class="form-control" value="" id="amount" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </form>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

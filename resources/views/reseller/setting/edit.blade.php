@extends('reseller.layout')

@section('styles')
@livewireStyles
<style>
    .nav-tabs {
        border: 2px solid #ddd;
    }
    .nav-tabs li:hover a,
    .nav-tabs li a.active {
        border-radius: 0;
        border-bottom-color: #ddd !important;
    }
    .nav-tabs li a.active {
        background-color: #f0f0f0 !important;
    }
    .nav-tabs li a:hover {
        border-bottom: 1px solid #ddd;
        background-color: #f7f7f7;
    }

    .is-invalid + .SumoSelect + .invalid-feedback {
        display: block;
    }


    .input-group {
        margin-bottom: 1rem;
    }
    .input-group-append {
        cursor: pointer;
    }
    .input-group input, .input-group select {
        margin-right: 1rem;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header py-2">Reseller <strong>Setting</strong></div>
            <div class="card-body p-2">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <ul class="nav nav-tabs list-group" role="tablist">
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('name') || $errors->has('email') || $errors->has('phone')) text-danger @endif active" data-toggle="tab" href="#item-1">General</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('payment_method') || $errors->has('payment_number')) text-danger @endif" data-toggle="tab" href="#item-2">Transaction</a></li>
                            <li class="nav-item rounded-0"><a class="nav-link @if($errors->has('password') || $errors->has('old_password') || $errors->has('password_confirmation')) text-danger @endif" data-toggle="tab" href="#item-3">Password</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6 col-md-8 col-xl-9">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('reseller.setting.update') }}" method="post">
                                    <div class="tab-content">
                                        @csrf
                                        @method('PATCH')
                                        <div class="tab-pane active" id="item-1" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">General</small></h4>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Name</label><span class="text-danger">*</span>
                                                        <input name="name" value="{{ old('name', $user->name) }}" id="" cols="30" rows="10" class="form-control @error('name') is-invalid @enderror">
                                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label><span class="text-danger">*</span>
                                                        <input name="email" value="{{ old('email', $user->email) }}" id="" cols="30" rows="10" class="form-control @error('email') is-invalid @enderror">
                                                        {!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label><span class="text-danger">*</span>
                                                        <input name="phone" value="{{ old('phone', $user->phone) }}" id="" cols="30" rows="10" class="form-control @error('phone') is-invalid @enderror">
                                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-2" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Transaction</small></h4>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group" id="ways">
                                                        <label for="payment">Transaction Ways</label>
                                                        @foreach($user->payment as $payment)
                                                        <div class="input-group" data-id="{{ $loop->index }}">
                                                            <select name="payment[{{ $loop->index }}][method]" class="form-control @error('payment.'.$loop->index.'.method') is-invalid @enderror">
                                                                <option value="">Select Method</option>
                                                                @php $old_method = old('payment.'.$loop->index.'.method', $payment->method) @endphp
                                                                @foreach(config('transaction.ways') as $way)
                                                                    <option value="{{ $way }}" @if($way == $old_method) selected @endif>{{ $way }}</option>
                                                                @endforeach
                                                            </select>
                                                            {!! $errors->first('payment.'.$loop->index.'.method', '<span class="invalid-feedback">:message</span>') !!}
                                                            <input type="text" name="payment[{{ $loop->index }}][number]" placeholder="Payment Number" value="{{ old('payment.'.$loop->index.'.number', $payment->number) }}" class="form-control @error('payment_number') is-invalid @enderror">
                                                            {!! $errors->first('payment.'.$loop->index.'.number', '<span class="invalid-feedback">:message</span>') !!}
                                                            <div class="input-group-append">
                                                                <span class="input-group-text bg-danger remove-way">&minus;</span>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col mb-3">
                                                    <a href="" id="add-way">Add New Way</a>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="item-3" role="tabpanel">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4><small class="border-bottom mb-1">Change Password</small></h4>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Password</label><span class="text-danger">*</span>
                                                        <input name="password" value="{{ old('password') }}" id="" cols="30" rows="10" class="form-control @error('password') is-invalid @enderror">
                                                        {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password_confirmation">Confirm Password</label><span class="text-danger">*</span>
                                                        <input name="password_confirmation" value="{{ old('password_confirmation') }}" id="" cols="30" rows="10" class="form-control @error('password_confirmation') is-invalid @enderror">
                                                        {!! $errors->first('password_confirmation', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="old_password">Old Password</label><span class="text-danger">*</span>
                                                        <input name="old_password" value="{{ old('old_password') }}" id="" cols="30" rows="10" class="form-control @error('old_password') is-invalid @enderror">
                                                        {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0">
                                                    @method('PATCH')
                                                    <button type="submit" formaction="{{ route('reseller.password.update') }}" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#add-way').click(function(e) {
            e.preventDefault();
            var last = $('#ways').children('.input-group').last();
            var id = 0;
            if(last.length) {
                id = last.data('id') + 1;
            }


            $('#ways').append(`<div class="input-group" data-id="`+id+`">
                <select name="payment[`+id+`][method]" class="form-control @error('payment.`+id+`.method') is-invalid @enderror">
                    <option value="">Select Method</option>
                    @php $old_method = old('payment.`+id+`.method', $payment->method) @endphp
                    @foreach(config('transaction.ways') as $way)
                        <option value="{{ $way }}">{{ $way }}</option>
                    @endforeach
                </select>
                {!! $errors->first('payment.`+id+`.method', '<span class="invalid-feedback">:message</span>') !!}
                <input type="text" name="payment[`+id+`][number]" placeholder="Payment Number" value="{{ old('payment.`+id+`.number') }}" class="form-control @error('payment_number') is-invalid @enderror">
                {!! $errors->first('payment.`+id+`.number', '<span class="invalid-feedback">:message</span>') !!}
                <div class="input-group-append">
                    <span class="input-group-text bg-danger remove-way">&minus;</span>
                </div>
            </div>`);

            $('.remove-way').click(function(e) {
                e.preventDefault();
                $(this).parents('.input-group').remove();
            });
        })
    });
</script>
@endsection
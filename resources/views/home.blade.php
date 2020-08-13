@extends('layouts.app')

@section('content')
@if ($errors->has('success_message'))
<p class="alert alert-success">{{ $errors->first('success_message') }}</p>
@endif
@if ($errors->has('message'))
<p class="alert alert-danger">{{ $errors->first('message') }}</p>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Data</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="#">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ $user['first_name'] }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ $user['last_name'] }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $user['email'] }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Date of Birth</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="datepicker" name="dob" value="{{ $user['dob'] }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('membership') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Membership</label>

                            <div class="col-md-6">
                                <select class="form-control" name="membership" id="membership">
                                    @foreach(['Silver','Gold','Platinum','Black','VIP','VVIP'] as $v)
                                    @if($v == $user['membership'])
                                    <option selected>{{ $v }}</option>
                                    @else
                                    <option>{{ $v }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(sizeof($user['addresses']) > 0)
                        <div class="form-group{{ $errors->has('addresses') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Addresses</label>

                            <div class="col-md-6">
                                @foreach($user['addresses'] as $v)
                                <input type="text" class="form-control" value="{{ $v }}">
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
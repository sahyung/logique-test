@extends('layouts.app')

@section('content')
@if ($errors->has('success_message'))
<p class="alert alert-success">{{ $errors->first('success_message') }}</p>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Date of Birth</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="datepicker" name="dob">

                                @if ($errors->has('dob'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('membership') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Membership</label>

                            <div class="col-md-6">
                                <select class="form-control" name="membership" id="membership">
                                    <option selected="selected">Silver</option>
                                    <option>Gold</option>
                                    <option>Platinum</option>
                                    <option>Black</option>
                                    <option>VIP</option>
                                    <option>VVIP</option>
                                </select>

                                @if ($errors->has('membership'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('membership') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('addresses') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Addresses</label>

                            <div class="col-md-6">
                                <table id="dynamic_field">
                                    <tr>
                                        <td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
                                        <td><input type="text" name="addresses[]" placeholder="#Street name, #Zip_Code #City, #Country" class="form-control" style="width: 180%" /></td>
                                    </tr>
                                </table>
                                @if ($errors->has('addresses'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('addresses') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cc') ? ' has-error' : '' }}">
                            <div class="card-wrapper"></div>
                            <div class="col-md-6">
                                <label class="col-md-4 control-label">Credit Card Type</label>
                                <select class="form-control" name="cc_type">
                                    <option selected="selected">Visa</option>
                                    <option>Master</option>
                                </select>
                                @if ($errors->has('cc.type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cc.type') }}</strong>
                                </span>
                                @endif

                                <label class="col-md-4 control-label">Credit Card Number</label>
                                <input type="text" class="form-control" name="cc_number" placeholder="1234567812345678">
                                @if ($errors->has('cc.number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cc.number') }}</strong>
                                </span>
                                @endif

                                <label class="col-md-4 control-label">Credit Card Expiry (MM/YY)</label>
                                <input type="text" class="form-control" name="cc_expiry" placeholder="12/20">
                                @if ($errors->has('cc.expiry'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cc.expiry') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tnc') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Term and Condition</label>

                            <div class="col-md-6">
                                <input class="form-control" checked name="tnc" type="checkbox" value="yes">

                                @if ($errors->has('tnc'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tnc') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
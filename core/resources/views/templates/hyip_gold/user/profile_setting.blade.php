@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-4 mb-30">
            <div class="card custom--card">
                <div class="card-body">
                    <h4 class="mb-2">{{ $user->fullname }}</h4>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="las la-user base--color"></i> @lang('Username')</span> <span
                                class="fw-bold">{{ $user->username }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="las la-envelope base--color"></i> @lang('Email')</span> <span
                                class="fw-bold">{{ $user->email }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="las la-phone base--color"></i> @lang('Mobile')</span> <span
                                class="fw-bold">{{ $user->mobile }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="las la-globe base--color"></i> @lang('Country')</span> <span
                                class="fw-bold">{{ @$user->address->country }}</span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card custom--card">
                <div class="card-body">
                    <form class="register" action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('First Name')</label>
                                <input type="text" class="form-control form--control" name="firstname"
                                    value="{{ $user->firstname }}" required>
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('Last Name')</label>
                                <input type="text" class="form-control form--control" name="lastname"
                                    value="{{ $user->lastname }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('Address')</label>
                                <input type="text" class="form-control form--control" name="address"
                                    value="{{ @$user->address->address }}">
                            </div>
                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('State')</label>
                                <input type="text" class="form-control form--control" name="state"
                                    value="{{ @$user->address->state }}">
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('Zip Code')</label>
                                <input type="text" class="form-control form--control" name="zip"
                                    value="{{ @$user->address->zip }}">
                            </div>

                            <div class="form-group mb-3 col-sm-6">
                                <label class="form-label">@lang('City')</label>
                                <input type="text" class="form-control form--control" name="city"
                                    value="{{ @$user->address->city }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--outline-base w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

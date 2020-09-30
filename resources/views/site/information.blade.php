@extends('layouts.app')

@section('content')
        <!--Section: Contact v.2-->
        <section class="col-lg-12">

            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">Information</h2>
            <!--Section description-->
            <p class="text-center w-responsive mx-auto mb-5">Please fill-up fields. If not applicable, leave it blank.</p>

            <div class="row">

                <!--Grid column-->
                <div class="col-md-12 mb-md-0 mb-5">
                    <form id="contact-form" name="contact-form" action="{{ action('InformationController@generate') }}" method="POST">

                        <!--Grid row-->
                        <div class="row">

                            <!--Grid column-->
                            <div class="col-md-5">
                                <div class="md-form mb-0">
                                    <input type="text" id="name" name="first_name" class="form-control">
                                    <label for="first_name" class="">First Name</label>
                                </div>
                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-1">
                                <div class="md-form mb-0">
                                    <input type="text" id="initials" name="initials" class="form-control">
                                    <label for="initials" class="">Middle Initial</label>
                                </div>
                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-5">
                                <div class="md-form mb-0">
                                    <input type="text" id="last_name" name="last_name" class="form-control">
                                    <label for="last_name" class="">Last Name</label>
                                </div>
                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-1">
                                <div class="md-form mb-0">
                                    <input type="text" id="suffix_name" name="suffix_name" class="form-control">
                                    <label for="suffix_name" class="">Suffix</label>
                                </div>
                            </div>
                            <!--Grid column-->

                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <label for="gender" class="">Gender</label>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input id="gender-m" class="custom-control-input" type="radio" name="gender" value="M">
                                        <label for="gender-m" class="custom-control-label">Male</label>
                                    </div>
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input id="gender-f" class="custom-control-input" type="radio" name="gender" value="F">
                                        <label for="gender-f" class="custom-control-label">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="address" name="address" class="form-control">
                                    <label for="address" class="">Address</label>
                                </div>
                            </div>
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row">
                            <div class="col-md-1">
                                <div class="md-form mb-0">
                                    <input type="text" id="age" name="age" class="form-control">
                                    <label for="age" class="">Age</label>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="md-form mb-0">
                                    <input type="text" id="phone_number" name="phone_number" class="form-control">
                                    <label for="phone_number" class="">Phone Number</label>
                                </div>
                            </div>
                        </div>
                        <!--Grid row-->
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    </form>

                    <div class="text-center text-md-left">
                        <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
                    </div>
                    <div class="status"></div>
                </div>
                <!--Grid column-->

            </div>

        </section>
        <!--Section: Contact v.2-->

        <section class="col-lg-12 mt-5">
            <div class="row">
                <div class="col-md-12 mb-md-0 mb-5">
                <p>To scan QR Information, click <a href="{{ action('InformationController@scanner') }}">here</a>.</p>
                </div>
            </div>
        </section>
@endsection

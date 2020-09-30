@extends('layouts.app')

@section('extra_headers')
<meta name="csrf-token" content={{ csrf_token() }}>
@endsection

@section('content')
        <!--Section: Contact v.2-->
        <section class="col-lg-12">

            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">QR Scanner</h2>
            <!--Section description-->
            <p class="text-center w-responsive mx-auto mb-5">Test app qr scan.</p>

            <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-md-0 mb-5 mx-auto">
                    <form id="contact-form" name="contact-form" action="{{ action('InformationController@generate') }}" method="POST">
                        <div class="img-fluid" id="reader"></div>
                        @csrf
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
@endsection

@section('additional_scripts')
    <script src="{{asset('js/html5-qrcode.min.js')}}"></script>
    <script>
        // This method will trigger user permissions
            Html5Qrcode.getCameras().then(devices => {
            /**
             * devices would be an array of objects of type:
             * { id: "id", label: "label" }
             */
            if (devices && devices.length) {
                let cameraId = devices[0].id;
                console.log(cameraId);
                // .. use this to start scanning.
                const html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                cameraId,     // retreived in the previous step.
                {
                    fps: 10,    // sets the framerate to 10 frame per second
                    qrbox: 350,  // sets only 350 X 350 region of viewfinder to
                                // scannable, rest shaded.
                    aspectRatio: 1.333334
                },
                qrCodeMessage => {
                    doSubmitQr(qrCodeMessage, html5QrCode);
                },
                errorMessage => {
                    // parse error, ideally ignore it. For example:
                    console.log(`QR Code no longer in front of camera.`);
                })
                .catch(err => {
                // Start failed, handle it. For example,
                console.log(`Unable to start scanning, error: ${err}`);
                });
            }
            }).catch(err => {
            // handle err
            console.error(err);
            });

            function doSubmitQr(qrCodeMessage, html5QrCode)
            {
                console.log("DO SUBMIT FUNCTION APPEAR!");
                console.log("QR MESSAGE : ", qrCodeMessage);
                const url = "{{ route("AddQR") }}";
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const params = {
                    headers: {
                        "X-CSRF-TOKEN" : token,
                        "Content-Type" : 'application/json'
                    },
                    body: qrCodeMessage,
                    method: "POST",
                    mode: "same-origin",
                    cache: "no-cache"
                }
                fetch(url, params)
                    .then(  data => {
                        if(data.status == 500){
                            alert('Invalid QR Code');
                            // return data.status;
                            html5QrCode.clear();
                        }
                    })
                    .catch((error)=>{ console.error(error)} );

            }
    </script>
@endsection

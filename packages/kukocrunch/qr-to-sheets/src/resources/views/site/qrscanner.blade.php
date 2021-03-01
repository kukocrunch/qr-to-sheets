@extends('qrtosheets::layouts.app')

@section('extra_headers')
<meta name="csrf-token" content={{ csrf_token() }}>
@endsection

@section('content')
        <!--Section: Contact v.2-->
        <section class="col-lg-12">

            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">QR Scanner</h2>
            <!--Section description-->
            <p class="text-center w-responsive mx-auto mb-5">Simple QR Scan to Sheets.</p>

            <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-md-0 mb-5 mx-auto">
                    <div class="mb-5" id="notif">
                    </div>
                    <form id="contact-form" name="contact-form" action="{{ route('generate') }}" method="POST">
                        <div class="img-fluid" id="reader"></div>
                        @csrf
                    </form>
                    <div class="status"></div>
                </div>
                <!--Grid column-->

            </div>

            <div class="row mt-3">
                <div class="col-md-6 mb-md-0 mx-auto">
                    <div class="text-center text-md-left">
                        <a class="btn btn-primary" href="{{ route('home') }}">Generate QR</a>
                    </div>
                </div>
            </div>

        </section>
        <!--Section: Contact v.2-->
@endsection

@section('additional_scripts')
    <script src="{{asset('js/html5-qrcode.min.js')}}"></script>
    <script>


        $(document).ready(function(){
            $("#notif").alert();
        });


        function doSubmitQr(qrCodeMessage)
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
                        let errorMessage = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" id=\"alertNotif\">" + 
                            "<strong>Error!</strong> Something went wrong." + 
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button>" + 
                            "</div>";
                        $("#notif").append(errorMessage);
                    }
                    else if(data.status == 200){
                        let successMessage = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" id=\"alertNotif\">" +
                            "<strong>Success!</strong> Added QR data to Sheets. "+ 
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button>" + 
                            "</div>";
                        $("#notif").append(successMessage);
                    }
                    else if(data.status == 403){
                        let errorMessage = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\" id=\"alertNotif\">" + 
                            "<strong>Error 403</strong> Forbidden Access to Sheets API." +
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button>" + 
                            "</div>";
                        $("#notif").append(errorMessage);
                    }
                    else{
                        alert('unknown error');
                    }
                })
                .catch(error => {
                });

        }

        $("#notif").on('closed.bs.alert', function(){
            alert('closed notif!');
        });

        function onScanSuccess(qrMessage) {
            // handle the scanned code as you like
            // console.log(`QR matched = ${qrMessage}`);
            doSubmitQr(qrMessage);
            html5QrcodeScanner.clear();
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
            // console.warn(`QR error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
    	"reader", { fps: 10, qrbox: 250 }, /* verbose= */ true);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@endsection

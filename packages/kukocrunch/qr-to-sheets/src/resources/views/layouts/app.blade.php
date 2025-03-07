<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('extra_headers')
    <title>test</title>
    <!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid">

        <header class="row">
            header
        </header>

        <div id="main" class="row">

            <div id="content" class="col-lg-12">
                @yield('content')
            </div>

        </div>

        <footer class="row">
            footer
        </footer>
    </div>
</body>
@include('qrtosheets::includes.scripts')
</html>

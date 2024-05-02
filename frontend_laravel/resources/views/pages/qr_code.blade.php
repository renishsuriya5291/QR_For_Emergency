@extends('welcome')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center heading_div">
            <div class="head_text">
                <h2>QR Code Details</h2>
            </div>
        </div>

        <div class="div">
            <div class="row">
                @foreach($QRDetail as $detail)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $detail['field'] }}</h5>
                                <p class="card-text">{{ $detail['value'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="buttons d-flex justify-content-center mt-2 " >
                @php
                        $QRDetailJSON = json_encode($QRDetail);
                @endphp
                <button type="submit" onclick="sendMsgFunc(<?php echo htmlspecialchars($QRDetailJSON, ENT_QUOTES, 'UTF-8'); ?>)" class="btn btn-primary px-5 py-2">Send Message</button>
            </div>
        </div>
        <script>
            function sendMsgFunc(data){
                console.log(data);
            }
        </script>
    </div>
@endsection

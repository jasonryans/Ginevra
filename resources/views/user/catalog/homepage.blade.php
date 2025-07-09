@extends('user.base')
@section('content')
    <div class="container mt-5">
        <h1>Welcome to Ginevra</h1>
        <p>Your one-stop solution for all your needs.</p>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('images/service1.jpg') }}" class="card-img-top" alt="Service 1">
                    <div class="card-body">
                        <h5 class="card-title">Service 1</h5>
                        <p class="card-text">Description of Service 1.</p>  
                        <a href="{{ url('/services/service1') }}" class="btn btn-primary">Learn More</a>
@endsection
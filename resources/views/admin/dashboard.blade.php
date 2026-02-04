@extends('layouts.app')
@section('content')
<div class ="container">
    <h1>Welcome Admin {{auth()->user()->name}}</h1>
    <p> This is your admin dashboard. </p>
</div>
@endsection

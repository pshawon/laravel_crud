@extends("layouts.header")
 @section("title","Dashboard")

 @section("content")
    <h2>Hi {{ $user->name}}, Welcome to the Dashboard</h2>
    <p>This is the body content of your dashboard. You can add your own content here.</p>
    @endsection



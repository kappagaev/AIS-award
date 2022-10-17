@extends('layout')

@section('content')
    <h1>test</h1>
    <form method="post" action="/import" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="form-control">
        <br>
        <button class="btn btn-success">Import User Data</button>
    </form>
@endSection

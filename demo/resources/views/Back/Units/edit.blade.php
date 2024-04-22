@extends('Back.Layout.main')

@section('title', $title)

@section('content')
    <div class="container">
        <h1>Edit Unit</h1>

        {{-- Display errors if there are any form validation messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Method spoofing to make it a PUT request -->

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $unit->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $unit->email) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $unit->phone) }}">
            </div>

            <div class="form-group">
                <label for="coordinator">Coordinator:</label>
                <input type="text" class="form-control" id="coordinator" name="coordinator" value="{{ old('coordinator', $unit->coordinator) }}">
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $unit->address) }}">
            </div>

            <div class="form-group">
                <label for="starttime">Start Time:</label>
                <input type="time" class="form-control" id="starttime" name="starttime" value="{{ old('starttime', $unit->starttime) }}">
            </div>

            <div class="form-group">
                <label for="endtime">End Time:</label>
                <input type="time" class="form-control" id="endtime" name="endtime" value="{{ old('endtime', $unit->endtime) }}">
            </div>

            <div class="form-group">
                <label for="active">Active:</label>
                <input type="checkbox" id="active" name="active" {{ $unit->active ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
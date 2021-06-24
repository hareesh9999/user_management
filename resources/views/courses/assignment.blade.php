@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Assign Course To User</div>
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('success') !!}</li>
                        </ul>
                    </div>
                @elseif(\Session::has('danger'))
                    <div class="alert alert-danger">
                        <ul>
                            <li>{!! \Session::get('danger') !!}</li>
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('courses.subscribeuser') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="course" value="{{ $course[0]->title }}" required autocomplete="name" autofocus>
                            </div>
                            <input type="hidden" name="course_id" value="{{$course[0]->id}}">
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">users</label>

                            <div class="col-md-6">
                                <select name="users" required>
                                    <option value="">Select</option>
                                    @if(!empty($users))
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="hidden" name="user_name" value="{{$user->name}}">
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" name="Assign_Course" value="Assign Course">
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection
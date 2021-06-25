@extends('layouts.app')

@section('content')
<div class="container">
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Add New Course</h2></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('courses.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Title</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="name" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <textarea name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" name="Add" value="Add Course">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <h2>Courses List</h2>   
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Assigned user to course</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                      
                        <tbody>
                        @php $username = ''; $i=1;   @endphp
                        @if(!empty($courses))
                        @foreach($courses as $course)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$course->title}}</td>
                            <td>{{$course->description}}</td>
                            <td>@foreach($course->users as $courseusers) @php $username .= $courseusers->name.", ";
 @endphp  @endforeach @php $username = preg_replace("/\,$/", "", $username);  @endphp {{ $username }}</td>
                            <td><a href="{{ route('assignuser', ['id' => $course->id]) }}" class="btn btn-info">Assign Course</a></td>
                        </tr>
                        @endforeach
                        @endif
                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
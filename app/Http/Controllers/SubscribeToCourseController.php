<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notifications\SubscribedToCourse;
use App\Course;

class SubscribeToCourseController extends Controller
{
   public function __invoke(Course $course)
   {
       auth()->user()->subscribeToCourse($course);
       auth()->user()->notify(new SubscribedToCourse($course));
       return redirect()->route('courses.show',$course);
   }
}

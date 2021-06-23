<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SubscribedToCourse;
use App\User;
use App\Course;

class SubscribeToCourseController extends Controller
{
   public function __invoke(Course $course)
   {
       // Valid authenticated user should be subscribe
       auth()->user()->subscribeToCourse($course);
       // Valid user should be notified
       auth()->user()->notify(new SubscribedToCourse($course));
       
       return redirect()->route('courses.show',$course);
   }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SubscribedToCourse;
use App\User;
use App\Course;
use App\CourseUser;
use Session;

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

   public function courseToSubscriber(Request $request)
   {
       //dd($request->users);
       $user_name  = $request->user_name;
       if(CourseUser::where(['course_id'=>$request->course_id,'user_id'=>$request->users])->exists()){
           // return redirect()->route('courses.show',$course);
            return redirect()->back()->with(['danger'=>$user_name.' is already subscribed to this course']);
       }
       $course = Course::where('id',$request->course_id)->first();
       User::find($request->users)->subscribeToCourse($course);
       return redirect()->route('home');
   }
}

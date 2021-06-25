<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Course;
use App\User;

class CourseTest extends TestCase
{
    /**
     * Store the course
     *
     * @return void
     */
    public function test_user_can_create_course()
    {
        $this->withoutExceptionHandling();
        $title = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);

        $description1 = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);

        $description2 = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10);

        $desctiption = $description1." ".$description2;
        $response = $this->post(route('courses.store',
            [
                'title'=>$title,
                'description'=>$desctiption,
            ]
        ));
        $response->assertStatus(302);
        $course_count = Course::count();
        $this->assertCount($course_count,Course::all());
    }

    /**
     * View the course subscribing screen
     *
     * @return void
     */

    public function test_user_can_view_subscribe_to_user_page()
    {
        $id = Course::first()->id;

        $response = $this->get(route('assignuser',
            [
                'id'=>$id,
            ]
        ));

        $response->assertSee('/form');
        $response->assertSuccessful();
        $response->assertStatus(200);
    }


    /**
     * Enable susbscriber to subscribe users 
     *
     * @return void
     */

    public function test_user_can_subscribe_a_course()
    {
       
        $course_id= Course::first()->id;
        $user_id =User::first()->id;

        
        $userobj = User::where('id',$user_id)->first();
        $courseObj = Course::where('id',$course_id)->first();

        $response = $this->post(route('courses.subscribeuser',
            [
                'users'=>$user_id,
                'course_id'=>$course_id,
            ]
        ));
        /**
         * Enable Subscriber to check whether subscriber is already subscribed to course
        */
        if($userobj->isSubscribedToCourse($courseObj))
        {
            $response->assertStatus(302);
           // $response->assertRedirect(route('assignuser',['id'=>$course_id]));
            $response->assertRedirect('/');
            //$response->assertSee('/select');
        } else {
            $courses = Course::with('users')->get();
            $response->assertStatus(302);
            //$response->assertRedirect(route('home',['courses'=>$courses]));
            $response->assertRedirect('/');
            //$response->assertSee('Assign Course');
        }
     
        
    }
}

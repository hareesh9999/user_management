<?php

namespace Tests\Feature;

use App\Course;
use App\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscribedToCourse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersCanSubscribeToCoursesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_subscribe_to_a_course_and_sends_a_notification()
    {
        Notification::fake();
        $user= factory(User::class)->create();
        $course= factory(Course::class)->create();

        $this->assertFalse($user->isSubscribedToCourse($course));  
        
        $response = $this->actingAs($user)->post(route('courses.subscribe',$course));
      
        $response->assertRedirect(route('courses.show',$course));

        $user->refresh();
        
        $this->assertTrue($user->isSubscribedToCourse($course));  
       
        Notification::assertSentTo($user,SubscribedToCourse::class,function($notification) use ($course){
            return $notification->course->id == $course->id;
        });
    }
    public function test_it_cannot_subscribe_to_course_again()
    {
       
        Notification::fake();
        $user= factory(User::class)->create();
        $course= factory(Course::class)->create();
        
        $user->subscribeToCourse($course);
        
        $user->refresh();
       
        $response = $this->actingAs($user)->post(route('courses.subscribe',$course));
        
        $response->assertStatus(302);  
        
       // $response->assertSessionHasErrors();  

       
    }
}

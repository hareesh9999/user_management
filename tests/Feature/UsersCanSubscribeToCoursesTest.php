<?php

namespace Tests\Feature;

use Session;
use App\Course;
use App\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Notifications\SubscribedToCourse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersCanSubscribeToCoursesTest extends TestCase
{
    // Sync with DB migration for rolling back or refreshing data
    use DatabaseMigrations;
    // To save the records in DB
    use DatabaseTransactions;
    /**
     * Enable Subscriber to subscribe a course and send a notification
     *
     * @return true and false
     */
    public function test_it_subscribe_to_a_course_and_sends_a_notification()
    {
        // Create A fake notification
        Notification::fake();
        // Create A Fake User
        $user= factory(User::class)->create();
        // Create A Fake Course
        $course= factory(Course::class)->create();
        // Firstly set subscribed course assertion false    
        $this->assertFalse($user->isSubscribedToCourse($course)); 
        // Firstly the current user trying to subscribe a course using following route
        $response = $this->actingAs($user)->post(route('courses.subscribe',['course'=>$course]));
        // Then assert the redirection to courses show route
        $response->assertRedirect(route('courses.show',$course));
        // After the delete the oldest records for subscribed users
        $user->refresh();
        // After that course subscription set to true
        $this->assertTrue($user->isSubscribedToCourse($course));  
        //  Send a notification to subscriber
        Notification::assertSentTo($user,SubscribedToCourse::class,function($notification) use ($course){
            return $notification->course->id == $course->id;
        });
    }
    public function test_it_cannot_subscribe_to_course_again()
    {
        $this->withoutExceptionHandling();
        // Create A Fake User
        $user= factory(User::class)->create();
        // Create A Fake Course
        $course= factory(Course::class)->create();
        // User will try to subscribe a course again but fails with invalid Authentication
        $user->subscribeToCourse($course);
        // After the delete the oldest records for subscribed users
        $user->refresh();
        // Firstly the current user trying to subscribe a course using following route
        $response = $this->actingAs($user)->post(route('courses.subscribe',['course'=>$course,'_token' => csrf_token()]));
        // Since its not returning json response and moved to another route so it set to 302 status
        $response->assertStatus(302);  
        //$response->assertSessionHasErrors(['user'=>'The Course is already subscribed']);

       
    }
}

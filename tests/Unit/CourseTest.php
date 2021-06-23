<?php

namespace Tests\Unit;
use App\User;
use App\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function it_checks_if_user_subscribe_to_course()
    {
        $user= factory(User::class)->create();
        $course= factory(Course::class)->create();

        $this->assertFlase($user->isSubscribedToCourse($course));
        $user->subscribeToCourse($course);
        $user->refresh();
        $this->assertTrue($user->isSubscribedToCourse($course));
    }
}

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
     * Factory not supported in unit testing.
     *
     * @return void
     */

   /* public function it_checks_if_user_subscribe_to_course()
    {
        $user= factory(User::class)->create();
        $course= factory(Course::class)->create();

        $this->assertFlase($user->isSubscribedToCourse($course));
        $user->subscribeToCourse($course);
        $user->refresh();
        $this->assertTrue($user->isSubscribedToCourse($course));
    }
    */
}

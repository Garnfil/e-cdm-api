<?php

namespace Database\Seeders;

use App\Models\DiscussionComment;
use App\Models\DiscussionPost;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post1 = DiscussionPost::create([
            'user_id' => 1,
            'user_type' => 'student',
            'title' => 'Public Post 1',
            'content' => 'This is a public discussion post available to everyone.',
            'visibility' => 'public',
        ]);

        // Public Post 2
        $post2 = DiscussionPost::create([
            'user_id' => 1,
            'user_type' => 'instructor',
            'title' => 'Public Post 2',
            'content' => 'Another public discussion post for everyone to see.',
            'visibility' => 'public',
        ]);

        // Private Post (Restricted by Institute)
        $post3 = DiscussionPost::create([
            'user_id' => 1,
            'user_type' => 'student',
            'title' => 'Private Post for Institute',
            'content' => 'This post is restricted to a specific institute.',
            'visibility' => 'private',
            'institute_id' => 1,  // Assuming user1 belongs to an institute
        ]);

        // Private Post (Restricted by Course)
        $post4 = DiscussionPost::create([
            'user_id' => 1,
            'user_type' => 'instructor',
            'title' => 'Private Post for Course',
            'content' => 'This post is restricted to a specific course.',
            'visibility' => 'private',
            'course_id' => 1,  // Assuming user2 belongs to a course
        ]);

        // Add comments to posts
        DiscussionComment::create([
            'post_id' => 1,
            'user_id' => 1,
            'user_type' => 'Instructor',
            'comment' => 'Great public post! Thanks for sharing.',
        ]);

        DiscussionComment::create([
            'post_id' => 1,
            'user_id' => 1,
            'user_type' => 'Student',
            'comment' => 'Interesting discussion on this topic!',
        ]);
    }
}

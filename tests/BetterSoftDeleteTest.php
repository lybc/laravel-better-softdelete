<?php

namespace Lybc\BetterSoftDelete\Tests;

use Illuminate\Support\Facades\Schema;
use Lybc\BetterSoftDelete\Tests\Models\Comment;
use Lybc\BetterSoftDelete\Tests\Models\Post;
use Lybc\BetterSoftDelete\Tests\Models\User;

class BetterSoftDeleteTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        factory(Comment::class, 20)->create();
    }

    /**
     * 测试数据库结构和填充
     */
    public function testDbHasData()
    {
        $postColumns = Schema::getColumnListing('posts');
        $commentColumns = Schema::getColumnListing('comments');
        $this->assertEquals(['id', 'title', 'body', 'user_id', 'deleted_at'], $postColumns);
        $this->assertEquals(['id', 'post_id', 'content', 'deleted_at'], $commentColumns);
        $this->assertNotEmpty(Post::all());
        $this->assertNotEmpty(Comment::all());
        $this->assertNotEmpty(Post::first()->comments);
    }

    /**
     * 测试软删除字段
     */
    public function testDeletedAtColumn()
    {
        $post = Post::first();
        $this->assertEquals($post->deleted_at, 0);
    }

    /**
     * 测试软删除行为是否生效
     */
    public function testDelete()
    {
        $beforeDeletePostList = Post::all();

        $post = $this->getSoftDeletedModel();

        // 软删除成功且删除时间为当前时间戳
        $this->assertTrue($post->deleted_at > 0);
        $this->assertTrue(
            strtotime(date('Y-m-d H:i:s', $post->deleted_at)) === $post->deleted_at
        );
        $this->assertNotEquals($beforeDeletePostList, Post::all());

        $this->assertTrue($post->trashed());
    }

    /**
     * 测试取出被软删除的数据
     */
    public function testOnlyTrashed()
    {
        $post = $this->getSoftDeletedModel();

        $trashedPost = Post::onlyTrashed()->get();
        $this->assertNotEmpty($trashedPost);
        $this->assertEquals($trashedPost[0]->deleted_at, $post->deleted_at);
    }

    /**
     * 测试withTrashed方法
     */
    public function testWithTrashed()
    {
        $this->getSoftDeletedModel();
        $this->assertNotEmpty(Post::withTrashed()->get());
    }

    /**
     * 测试恢复软删除
     */
    public function testRestore()
    {
        $post = Post::withTrashed()->find($this->getSoftDeletedModel()->id);
        $post->restore();
        $this->assertTrue($post->deleted_at === 0);
        $this->assertEmpty(Post::onlyTrashed()->get());
    }

    /**
     * 测试关联删除
     */
    public function testRelateDelete()
    {
        $beforeDeleteCount = Comment::count();
        $post = Post::first();
        $this->assertTrue($post->comments()->count() > 0);
        $post->comments()->delete();
        $this->assertTrue(Comment::count() < $beforeDeleteCount);

        $trashedComments = $post->comments()->withTrashed()->get();
        $this->assertNotEmpty($trashedComments);

        foreach ($trashedComments as $trashedComment) {
            $this->assertTrue($trashedComment->deleted_at > 0);
            $trashedComment->restore();
            $this->assertTrue($trashedComment->deleted_at == 0);
        }

        $this->assertEquals(Comment::count(), $beforeDeleteCount);
    }

    /**
     * test has many cascade delete
     */
    public function testCascadeDeleteHasMany()
    {
        $commentsCount = Comment::count();
        $post = Post::first();
        $post->delete();
        $this->assertNotEquals($commentsCount, Comment::count());
    }

//    public function testCasCaseDeleteBelongsTo()
//    {
//        $usersCount = User::count();
//        $post = Post::first();
//        $post->delete();
//        $this->assertNotEquals($usersCount, User::count());
//    }

    private function getSoftDeletedModel()
    {
        $post = Post::first();
        $post->delete();
        return $post;
    }
}

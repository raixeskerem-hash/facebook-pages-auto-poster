<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskPage;

class PostingService
{
    protected BrowserService $browserService;

    public function __construct(BrowserService $browserService)
    {
        $this->browserService = $browserService;
    }

    /**
     * Execute a batch task: iterate over each assigned page and post content.
     *
     * @param  Task  $task
     * @return void
     */
    public function executeBatchTask(Task $task): void
    {
        $profilePath = $task->profile?->cookies ?? '';
        $browser = $this->browserService->openBrowserWithProfile($profilePath);

        try {
            $this->browserService->navigateToFacebook($browser);

            foreach ($task->taskPages as $taskPage) {
                if ($taskPage->isCompleted()) {
                    continue;
                }

                try {
                    $this->shareToPage($browser, $taskPage->page, $task->content);

                    $postId = $this->extractPostId($browser);
                    $taskPage->post_id = $postId;
                    $taskPage->status = 'completed';

                    if ($task->content->comment_enabled && $postId) {
                        sleep((int) ($task->content->comment_wait_seconds ?? 0));

                        if ($this->verifyPostBeforeComment($browser, $postId)) {
                            $this->addComment(
                                $browser,
                                $postId,
                                $task->content->comment_text ?? '',
                                $task->content->comment_link ?? ''
                            );

                            $taskPage->comment_id = $this->extractCommentId($browser, $postId);
                            $taskPage->comment_status = 'completed';
                        }
                    }
                } catch (\Throwable $e) {
                    $this->logError($taskPage, $e->getMessage());
                    $taskPage->status = 'failed';
                }

                $taskPage->save();

                $task->increment('completed_pages');
            }

            $task->status = 'completed';
            $task->save();
        } finally {
            $this->browserService->closeBrowser($browser);
        }
    }

    /**
     * Share content to a specific Facebook page.
     *
     * @param  mixed  $browser
     * @param  mixed  $page
     * @param  mixed  $content
     * @return void
     */
    protected function shareToPage($browser, $page, $content): void
    {
        $this->switchToPage($browser, $page);
        $this->sharePost($browser, $content);
    }

    /**
     * Switch the active Facebook page context in the browser.
     *
     * @param  mixed  $browser
     * @param  mixed  $page
     * @return void
     */
    protected function switchToPage($browser, $page): void
    {
        // Navigate to page and switch context
        // e.g. $browser->get('https://www.facebook.com/' . $page->page_id);
    }

    /**
     * Share a post (text, media, link) using the browser.
     *
     * @param  mixed  $browser
     * @param  mixed  $content
     * @return void
     */
    protected function sharePost($browser, $content): void
    {
        // Type the post text into the composer
        // e.g. find the "What's on your mind?" input and send_keys($content->text)

        if ($content->media_path) {
            $this->addMedia($browser, $content->media_path);
        }

        if ($content->link_url) {
            $this->addLink($browser, $content->link_url);
        }
    }

    /**
     * Refresh / reload the current page in the browser.
     *
     * @param  mixed  $browser
     * @return void
     */
    protected function refreshPage($browser): void
    {
        if ($browser && method_exists($browser, 'navigate')) {
            $browser->navigate()->refresh();
        }
    }

    /**
     * Add a comment to a Facebook post.
     *
     * @param  mixed   $browser
     * @param  string  $postId
     * @param  string  $commentText
     * @param  string  $commentLink
     * @return void
     */
    protected function addComment($browser, string $postId, string $commentText, string $commentLink): void
    {
        // Navigate to the post, find comment box, type comment + link, submit
    }

    /**
     * Extract the Facebook post ID from the current browser URL or page source.
     *
     * @param  mixed  $browser
     * @return string|null
     */
    protected function extractPostId($browser): ?string
    {
        // Parse the current URL or DOM for the post ID
        return null;
    }

    /**
     * Extract a comment ID from the page after commenting.
     *
     * @param  mixed   $browser
     * @param  string  $postId
     * @return string|null
     */
    protected function extractCommentId($browser, string $postId): ?string
    {
        // Parse the page DOM/URL for the comment ID
        return null;
    }

    /**
     * Upload media (image / video) using the browser.
     *
     * @param  mixed   $browser
     * @param  string  $mediaPath
     * @return void
     */
    protected function addMedia($browser, string $mediaPath): void
    {
        // Interact with the file upload element in the browser
    }

    /**
     * Add a link to the post composer in the browser.
     *
     * @param  mixed   $browser
     * @param  string  $linkUrl
     * @return void
     */
    protected function addLink($browser, string $linkUrl): void
    {
        // Type the link into the post composer
    }

    /**
     * Log an error for a task page.
     *
     * @param  TaskPage  $taskPage
     * @param  string    $message
     * @return void
     */
    protected function logError(TaskPage $taskPage, string $message): void
    {
        $taskPage->logs()->create([
            'step'          => 'error',
            'action'        => 'error',
            'error_message' => $message,
            'status'        => 'failed',
            'started_at'    => now(),
            'completed_at'  => now(),
        ]);
    }

    /**
     * Verify a post exists on Facebook before attempting to comment.
     *
     * @param  mixed   $browser
     * @param  string  $postId
     * @return bool
     */
    protected function verifyPostBeforeComment($browser, string $postId): bool
    {
        // Navigate to the post URL and check it is accessible
        return $postId !== null;
    }
}

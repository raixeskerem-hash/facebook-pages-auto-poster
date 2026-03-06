<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskPage;

class PostingService
{
    /** @var BrowserService */
    protected $browserService;

    public function __construct(BrowserService $browserService = null)
    {
        $this->browserService = $browserService ?? new BrowserService();
    }

    /**
     * Execute a batch posting task across all associated pages.
     */
    public function executeBatchTask(Task $task): void
    {
        foreach ($task->taskPages as $taskPage) {
            $browser = $this->browserService->openBrowserWithProfile($task->profile->cookies ?? '');
            try {
                $this->shareToPage($browser, $taskPage->page, $task->content);
                $taskPage->status = 'completed';
                $taskPage->save();
                $task->increment('completed_pages');
            } catch (\Throwable $e) {
                $this->logError($taskPage, $e->getMessage());
                $taskPage->status = 'failed';
                $taskPage->save();
            } finally {
                $this->browserService->closeBrowser();
            }
        }

        $task->status = 'completed';
        $task->save();
    }

    /**
     * Share content to a specific Facebook page.
     */
    public function shareToPage($browser, $page, $content): void
    {
        $this->switchToPage($browser, $page);
        $postId = $this->sharePost($browser, $content);

        if ($content->comment_enabled && $content->comment_text) {
            if ($content->comment_wait_seconds > 0) {
                sleep($content->comment_wait_seconds);
            }
            $this->addComment($browser, $postId, $content->comment_text, $content->comment_link);
        }
    }

    /**
     * Switch the browser session to the given Facebook page.
     */
    public function switchToPage($browser, $page): void
    {
        $this->browserService->navigateToFacebook();
        // Additional page-switching logic (e.g. navigate to page URL) goes here
    }

    /**
     * Share a post on the current page using the browser.
     *
     * @return string|null The extracted post ID.
     */
    public function sharePost($browser, $content): ?string
    {
        if ($content->media_path) {
            $this->addMedia($browser, $content->media_path);
        }

        if ($content->link_url) {
            $this->addLink($browser, $content->link_url);
        }

        return $this->extractPostId($browser);
    }

    /**
     * Refresh the current page in the browser.
     */
    public function refreshPage($browser): void
    {
        // Browser-specific refresh logic
    }

    /**
     * Add a comment to a post.
     */
    public function addComment($browser, string $postId, string $commentText, ?string $commentLink = null): ?string
    {
        // Browser-specific logic to type $commentText (and optionally append $commentLink) as a comment
        return $this->extractCommentId($browser, $postId);
    }

    /**
     * Extract the post ID from the current browser state.
     */
    public function extractPostId($browser): ?string
    {
        return null;
    }

    /**
     * Extract the comment ID for a given post from the current browser state.
     */
    public function extractCommentId($browser, string $postId): ?string
    {
        return null;
    }

    /**
     * Add media (image/video) to the post being composed.
     */
    public function addMedia($browser, string $mediaPath): void
    {
        // Browser-specific media upload logic
    }

    /**
     * Add a link to the post being composed.
     */
    public function addLink($browser, string $linkUrl): void
    {
        // Browser-specific link insertion logic
    }

    /**
     * Log an error for a task page.
     */
    public function logError(TaskPage $taskPage, string $message): void
    {
        $taskPage->logs()->create([
            'step'          => 'error',
            'action'        => 'error',
            'log_message'   => $message,
            'error_message' => $message,
            'status'        => 'failed',
            'started_at'    => now(),
            'completed_at'  => now(),
        ]);
    }
}

<?php include __DIR__ . '/../../layouts/header.php' ?>

<?php
$priorityClass = match ($task['priority'] ?? null) {
    'high' => 'bg-danger-300',
    'medium' => 'bg-warning-300',
    'low' => 'bg-success-400',
    default => 'bg-bgray-600'
};
$statusClass = match ($task['status'] ?? null) {
    'on-going' => 'bg-warning-300',
    'pending' => 'bg-danger-300',
    'completed' => 'bg-success-400',
    default => 'bg-bgray-600'
};
?>


<div class="bg-white p-6 rounded-lg shadow-lg mb-6 dark:bg-darkblack-600 text-black dark:text-white">
    <div class="flex justify-between mb-6">
        <!-- Back Button -->
        <a href="<?= isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : BASE_ENDPOINT . '/' ?>"
            class="inline-flex items-center text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:text-white">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back
        </a>

        <div class="flex items-center">
            <!-- Edit Button -->
            <a href="<?= BASE_ENDPOINT . '/tasks/' . $task['id'] . '/edit' ?>"
                class="inline-flex items-center text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:text-white">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4h10M4 20l4-4m0 0l8-8m-8 8H4v4z"></path>
                </svg>
                Edit
            </a>

            <!-- Delete Button -->
            <a onclick="deleteData('<?= BASE_ENDPOINT . '/tasks/' ?>', <?= $task['id'] ?>, 'Task')"
                class="inline-flex items-center text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:text-white ml-2 cursor-pointer">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                Delete
            </a>
        </div>
    </div>

    <!-- Task Details Card -->
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="border-b pb-4 border-gray-200 dark:border-darkblack-400">
            <h1 class="text-2xl font-bold dark:text-white text-justify text-black"><?= ucfirst($task['title']) ?></h1>
            <div class="flex items-center space-x-2 mt-2">
                <span class="px-2 py-1 text-sm rounded-full <?= $priorityClass ?>">
                    <?= ucfirst($task['priority'] ?? 'No Priority') ?>
                </span>
                <span class="px-2 py-1 text-sm rounded-full <?= $statusClass ?>">
                    <?= ucfirst($task['status'] ?? 'No Status') ?>
                </span>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</h3>
                    <p class="text-gray-700 dark:text-white text-justify"><?= ucfirst($task['description']) ?></p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Due Date</h3>
                    <p class="text-gray-700 dark:text-white">
                        <?= date('M j, Y \a\t g:i A', strtotime($task['due_date'])) ?>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Reminder Time</h3>
                    <div class="flex items-center">
                        <p class="text-gray-700 dark:text-white text-justify mr-2">
                            <?= array_key_exists('reminder_time', $reminder) ? date('M j, Y \a\t g:i A', strtotime($reminder['reminder_time'])) : 'None' ?>
                        </p>

                        <?php if ($reminder): ?>
                            <a href="<?= BASE_ENDPOINT . '/reminders/' . $reminder['id'] . '/detail' ?>"
                                class="px-2 py-1 text-sm rounded-full bg-success-400 hover:bg-success-600 text-center items-center">
                                View Detail
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</h3>
                    <p class="text-gray-700 dark:text-white">
                        <?= date('M j, Y \a\t g:i A', strtotime($task['created_at'])) ?>
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Last Updated</h3>
                    <p class="text-gray-700 dark:text-white">
                        <?= date('M j, Y \a\t g:i A', strtotime($task['updated_at'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php' ?>
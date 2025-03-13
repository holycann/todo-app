<?php include __DIR__ . '/../layouts/header.php' ?>

<div class="bg-white shadow rounded-lg p-6 dark:bg-darkblack-600">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-bgray-300 dark:border-darkblack-400">
                    <th class="px-6 py-3 text-left text-sm text-gray-500 dark:text-white font-bold">Title</th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500 dark:text-white font-bold">Category</th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500 dark:text-white font-bold">Completed Date
                    </th>
                    <th class="px-6 py-3 text-left text-sm text-gray-500 dark:text-white font-bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($completedTasks as $task): ?>
                    <tr class="border-b border-bgray-300 dark:border-darkblack-400 dark:text-white text-black">
                        <td class="px-6 py-4"><?= htmlspecialchars($task['title']) ?></td>
                        <td class="px-6 py-4"><?= ucfirst($task['category']) ?></td>
                        <td class="px-6 py-4"><?= date('M j, Y H:i', strtotime($task['updated_at'])) ?></td>
                        <td class="px-6 py-4">
                            <a href="<?= BASE_ENDPOINT ?>/tasks/<?= $task['id'] ?>/detail" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php' ?>
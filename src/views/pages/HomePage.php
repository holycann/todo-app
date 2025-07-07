<?php include __DIR__ . '/../layouts/header.php' ?>

<p class="text-gray-500 mb-4 dark:text-bgray-50 text-xl"><i class="fas fa-tasks"></i> <?= count($tasksToday) ?> tasks
</p>
<div class="flex flex-col md:flex-row md:space-x-4">
    <div class="w-full md:w-1/3 ml-2">
        <h2 class="text-xl font-bold text-gray-500 mb-2 dark:text-gray-50">
            <?= isset($todayDate) ? $todayDate . ' - Today' : 'Today' ?>
        </h2>
        <div class="grid grid-cols-4 grid-flow-col gap-4 mt-4">
            <?php $no = 1; ?>
            <?php foreach ($tasksToday as $task): ?>
                <?php

                $priorityClass = match ($task['priority'] ?? null) {
                    'high' => 'bg-danger-300',
                    'medium' => 'bg-warning-300',
                    'low' => 'bg-success-400',
                    default => 'bg-bgray-600'
                };

                ?>
                <div class="w-full max-w-xl">
                    <div
                        class="flex justify-between pt-2 px-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-darkblack-600 dark:border-darkblack-400">
                        <div class="flex justify-center align-center pl-2">
                            <h3 class="text-black dark:text-white text-sm font-semibold"><?= ucwords($task['category']) ?>
                            </h3>
                        </div>
                        <div>
                            <button id="dropdownButton<?= $no ?>" data-dropdown-toggle="dropdown<?= $no ?>"
                                class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                                type="button">
                                <span class="sr-only">Open dropdown</span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 16 3">
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdown<?= $no ?>"
                                class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2" aria-labelledby="dropdownButton">
                                    <li>
                                        <a href="<?= BASE_ENDPOINT . '/tasks/' . $task['id'] . '/detail' ?>"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Detail</a>
                                    </li>
                                    <li>
                                        <a href="<?= BASE_ENDPOINT . '/tasks/' . $task['id'] . '/edit' ?>"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a onclick="deleteData('<?= BASE_ENDPOINT . '/tasks/' ?>', <?= $task['id'] ?>, 'Task')"
                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-black cursor-pointer">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex flex-col items-start justify-between px-4 bg-white border border-gray-200 rounded-top-lg shadow-sm dark:bg-darkblack-600 dark:border-darkblack-400 pt-2 h-80">
                        <div class="mt-2 w-full overflow-hidden">
                            <h3 class="text-black text-xl dark:text-white font-bold mb-2 text-justify">
                                <?= !empty($task['title']) ? mb_strimwidth(ucfirst($task['title']), 0, 30, "...") : 'No Title' ?>
                            </h3>
                            <p class="text-black dark:text-white text-sm break-words whitespace-normal w-full text-justify"
                                style="overflow-wrap: break-word; word-break: break-word;">
                                <?= !empty($task['description']) ? mb_strimwidth($task['description'], 0, 300, "...") : 'No Description' ?>
                            </p>
                        </div>

                        <div class="pb-4">
                            <form class="max-w-sm">
                                <select id="underline_select" name="status"
                                    class="block py-2.5 w-full text-sm text-black dark:text-white bg-transparent border-0 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 dark:bg-darkblack-600 focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                    data-task-id="<?= $task['id'] ?>" style="padding-left: 0">

                                    <?php
                                    $statusOptions = ['on-going', 'pending', 'completed'];
                                    $selectedStatus = $task['status'] ?? '';

                                    if (empty($selectedStatus)) {
                                        echo '<option value=""' . ($selectedStatus === '' ? ' selected' : '') . '>No Status</option>';
                                    }

                                    foreach ($statusOptions as $option) {
                                        echo '<option value="' . $option . '"' . ($selectedStatus === $option ? ' selected' : '') . '>' . ucfirst($option) . '</option>';
                                    }
                                    ?>
                                </select>
                            </form>

                            <button type="button"
                                class="text-white <?= $priorityClass ?? 'bg-gray-400' ?> rounded-lg text-sm px-4 text-center me-2 mb-2">
                                <?= isset($task['priority']) ? ucwords($task['priority']) : 'No Priority' ?>
                            </button>

                            <div class="flex items-center justify-center gap-4">
                                <p class="text-black dark:text-white text-sm mt-2">
                                    <i class="fas fa-calendar"></i>
                                    <?= !empty($task['due_date']) ? date('h:i A', strtotime($task['due_date'])) : 'No Due Date' ?>
                                </p>
                                <p class="text-black dark:text-white text-sm mt-2">
                                    <i class="fas fa-bell"></i>
                                    <?= !empty($reminders[$task['id']]['reminder_time']) ? date('h:i A', strtotime($reminders[$task['id']]['reminder_time'])) : 'No Reminder' ?>
                                    <?php if (isset($reminders[$task['id']]['task_id'])): ?>
                                        <a href="<?= BASE_ENDPOINT . '/reminders/' . $reminders[$task['id']]['id'] . '/detail' ?>"
                                            class="px-2 py-1 text-sm rounded-full bg-success-400 hover:bg-success-600 text-center items-center text-sm">
                                            View Reminder
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $no++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php' ?>